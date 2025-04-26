<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Models\UnitReview;

class UnitReviewRepo
{
    public function create(array $data)
    {
        $data['tenant_id'] = auth()->id();
        $data['rating'] = $this->calculateAverageRating($data);

        $exists = UnitReview::where('tenant_id', $data['tenant_id'])
            ->where('unit_id', $data['unit_id'])
            ->exists();

        $unitReview = UnitReview::updateOrCreate(
            [
                'tenant_id' => $data['tenant_id'],
                'unit_id' => $data['unit_id'],
            ],
            $data
        );

        $this->updateUnitRatingDetails($unitReview, $exists);

        return $unitReview;
    }

    protected function calculateAverageRating(array $data): float
    {
        $ratings = [
            $data['value'],
            $data['communication'],
            $data['check_in'],
            $data['accuracy'],
            $data['cleanliness'],
        ];

        return array_sum($ratings) / count($ratings);
    }

    protected function updateUnitRatingDetails(UnitReview $unitReview, bool $isNewReview): void
    {
        $unit = Unit::findOrFail($unitReview->unit_id);
        $ratingIndex = round($unitReview->rating);

        $ratingDetails = $this->initializeRatingDetails($unit);

        $this->updateRatingCounts($ratingDetails, $ratingIndex, $isNewReview);

        $averages = $this->getRatingAverages($unitReview->unit_id);

        $this->updateRatingAverages($ratingDetails, $averages);

        $unit->rating_details = $ratingDetails;
        $unit->save();
    }

    protected function initializeRatingDetails(Unit $unit): array
    {
        $ratingDetails = is_array($unit->rating_details) ? $unit->rating_details : [];

        for ($i = 1; $i <= 5; $i++) {
            $key = 'overall_rating_' . $i;
            $ratingDetails[$key] = $ratingDetails[$key] ?? 0;
        }

        $ratingDetails['total_reviewers'] = $ratingDetails['total_reviewers'] ?? 0;

        return $ratingDetails;
    }

    protected function updateRatingCounts(array &$ratingDetails, int $ratingIndex, bool $isNewReview): void
    {
        if ($isNewReview) {
            $ratingDetails['overall_rating_' . $ratingIndex] += 1;
            $ratingDetails['total_reviewers'] += 1;
        } else {
            $previousIndex = max(1, $ratingIndex - 1);
            $ratingDetails['overall_rating_' . $previousIndex] -= 1;
            $ratingDetails['overall_rating_' . $ratingIndex] += 1;
        }
    }

    protected function getRatingAverages(string $unitId): object
    {
        return UnitReview::where('unit_id', $unitId)
            ->selectRaw('
            AVG(rating) AS rating_average,
            AVG(communication) AS communication_average,
            AVG(check_in) AS check_in_average,
            AVG(accuracy) AS accuracy_average,
            AVG(cleanliness) AS cleanliness_average,
            AVG(value) AS value_average
        ')
            ->first();
    }

    protected function updateRatingAverages(array &$ratingDetails, object $averages): void
    {
        $ratingDetails['current_overall_rating'] = (float) $averages->rating_average;
        $ratingDetails['communication'] = (float) $averages->communication_average;
        $ratingDetails['check_in'] = (float) $averages->check_in_average;
        $ratingDetails['accuracy'] = (float) $averages->accuracy_average;
        $ratingDetails['cleanliness'] = (float) $averages->cleanliness_average;
        $ratingDetails['value'] = (float) $averages->value_average;
    }
}
