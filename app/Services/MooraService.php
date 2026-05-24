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

        // 1. Prepare Decision Matrix and calculate Square Sum for each criteria
        $squareSums = [];
        foreach ($criteria as $c) {
            $sum = 0;
            foreach ($alternatives as $alt) {
                $score = $alt['scores'][$c['id']] ?? 0;
                $sum += pow($score, 2);
            }
            $squareSums[$c['id']] = sqrt($sum);
        }

        // 2 & 3. Normalization and Weighted Normalization
        $results = [];
        foreach ($alternatives as $alt) {
            $optimizationValue = 0;
            $normalizedScores = [];

            foreach ($criteria as $c) {
                $score = $alt['scores'][$c['id']] ?? 0;
                
                // Avoid division by zero
                $normalized = ($squareSums[$c['id']] != 0) ? ($score / $squareSums[$c['id']]) : 0;
                $weighted = $normalized * ($c['weight'] / 100);
                
                $normalizedScores[$c['id']] = [
                    'normalized' => $normalized,
                    'weighted' => $weighted
                ];

                if ($c['type'] === 'benefit') {
                    $optimizationValue += $weighted;
                } else {
                    $optimizationValue -= $weighted;
                }
            }

            $results[] = [
                'id' => $alt['id'],
                'name' => $alt['name'],
                'scores' => $alt['scores'],
                'normalized_scores' => $normalizedScores,
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
