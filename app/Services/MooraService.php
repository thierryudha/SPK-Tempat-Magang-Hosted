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

        // 1. Prepare Decision Matrix with score inversion for 'Cost'
        $processedAlternatives = [];
        foreach ($alternatives as $alt) {
            $processedScores = [];
            foreach ($criteria as $c) {
                $originalScore = $alt['scores'][$c['id']] ?? 0;
                
                // Logic inversion for MOORA: 
                // For 'Benefit', high score is good (5 = 5).
                // For 'Cost', low input is good (1 = 5, 5 = 1).
                if (strtolower($c['type']) === 'cost') {
                    $processedScores[$c['id']] = 6 - $originalScore;
                } else {
                    $processedScores[$c['id']] = $originalScore;
                }
            }
            $processedAlternatives[] = [
                'id' => $alt['id'],
                'name' => $alt['name'],
                'original_scores' => $alt['scores'], // keep for reference
                'scores' => $processedScores // used for calculation
            ];
        }

        // 2. Calculate Square Sum for each criteria (using processed scores)
        $squareSums = [];
        foreach ($criteria as $c) {
            $sum = 0;
            foreach ($processedAlternatives as $alt) {
                $sum += pow($alt['scores'][$c['id']], 2);
            }
            $squareSums[$c['id']] = sqrt($sum);
        }

        // 3. Normalization and Weighted Normalization
        $results = [];
        foreach ($processedAlternatives as $alt) {
            $sumBenefit = 0;
            $sumCost = 0;
            $normalizedScores = [];

            foreach ($criteria as $c) {
                $score = $alt['scores'][$c['id']];
                
                // Avoid division by zero
                $normalized = ($squareSums[$c['id']] != 0) ? ($score / $squareSums[$c['id']]) : 0;
                $weighted = $normalized * ($c['weight'] / 100);
                
                $normalizedScores[$c['id']] = [
                    'normalized' => $normalized,
                    'weighted' => $weighted
                ];

                // NOTE: Since we already inverted Cost scores in Step 1, 
                // all criteria are now treated as "more is better" (Benefit-like).
                // So we add all weighted scores to sumBenefit.
                $sumBenefit += $weighted;
            }

            $optimizationValue = $sumBenefit; // No subtraction needed because costs are already inverted

            $results[] = [
                'id' => $alt['id'],
                'name' => $alt['name'],
                'scores' => $alt['original_scores'],
                'normalized_scores' => $normalizedScores,
                'sum_benefit' => $sumBenefit,
                'sum_cost' => 0,
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
