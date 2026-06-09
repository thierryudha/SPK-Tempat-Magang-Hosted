<?php

namespace App\Services;

class MooraService
{
    /**
     * Calculate MOORA ranking.
     * 
     * @param array $alternatives List of alternatives with their scores for each criteria.
     * @param array $criteria List of criteria with their weights and types.
     * @return array Ranked alternatives.
     */
    public function calculate(array $alternatives, array $criteria): array
    {
        if (empty($alternatives) || empty($criteria)) {
            return [];
        }

        // 1. Prepare Decision Matrix
        $matrix = [];
        foreach ($alternatives as $alt) {
            $matrix[] = [
                'id' => $alt['id'],
                'name' => $alt['name'],
                'scores' => $alt['scores']
            ];
        }

        // 2. Calculate Square Sum for each criteria (Normalization denominator)
        $squareSums = [];
        foreach ($criteria as $c) {
            $sum = 0;
            foreach ($matrix as $alt) {
                $score = $alt['scores'][$c['id']] ?? 0;
                $sum += pow($score, 2);
            }
            $squareSums[$c['id']] = sqrt($sum);
        }

        // 3. Normalization, Weighting, and Yi Calculation
        $results = [];
        foreach ($matrix as $alt) {
            $sumBenefit = 0;
            $sumCost = 0;
            $normalizedScores = [];

            foreach ($criteria as $c) {
                $score = $alt['scores'][$c['id']] ?? 0;
                
                // Normalization: x / sqrt(sum(x^2))
                $normalized = ($squareSums[$c['id']] != 0) ? ($score / $squareSums[$c['id']]) : 0;
                
                // Weighting: normalized * weight (weight is percentage, e.g., 40)
                $weighted = $normalized * ($c['weight'] / 100);
                
                $normalizedScores[$c['id']] = [
                    'normalized' => $normalized,
                    'weighted' => $weighted
                ];

                if (strtolower($c['type']) === 'cost') {
                    $sumCost += $weighted;
                } else {
                    $sumBenefit += $weighted;
                }
            }

            // Optimization Value (Yi) = SUM(Benefit) - SUM(Cost)
            $optimizationValue = $sumBenefit - $sumCost;

            $results[] = [
                'id' => $alt['id'],
                'name' => $alt['name'],
                'scores' => $alt['scores'],
                'normalized_scores' => $normalizedScores,
                'sum_benefit' => $sumBenefit,
                'sum_cost' => $sumCost,
                'optimization_value' => $optimizationValue
            ];
        }

        // 4. Ranking
        usort($results, function ($a, $b) {
            return $b['optimization_value'] <=> $a['optimization_value'];
        });

        foreach ($results as $index => &$res) {
            $res['rank'] = $index + 1;
        }

        return $results;
    }
}
