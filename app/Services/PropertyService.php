<?php

namespace App\Services;

use App\Models\Feature;
use App\Models\Property;
use App\Models\UnitFeatures;
use App\Repositories\LocationRepo;
use App\Repositories\PropertyRepo;
use App\Repositories\propertySection\UnitFeaturesRepo;
use App\Services\propertySection\FeatureService;
use App\Traits\Media;
use Illuminate\Support\Facades\Auth;

class PropertyService
{
    use Media;

    public function __construct(
        private PropertyRepo $propertyRepo,
        private LocationRepo $locationRepo,
        private UnitService $unitService,
        private UnitFeaturesRepo $unitFeaturesRepo,
        private CategoryService $categoryService,
        private FeatureService $featureService,
    ) {
    }

    public function index(int $per_page)
    {
        return $this->propertyRepo->filterProperties($per_page);
    }

    public function store(array $data): ?array
    {
        $response = [];
        $requiredKeys = ['description1', 'name', 'location', 'property_id'];

        if (!empty(array_intersect_key(array_flip($requiredKeys), $data))) {
            $property = $this->propertyRepo->storeProperty($data);
            $data['property_id'] = $property->id ?? $data['property_id'];

            if (array_key_exists('location', $data)) {
                $modelType = Property::class;
                $this->locationRepo->storeLocation($data['location'], $data['property_id'], $modelType);
            }
            $response['property'] = $property;
        }

        if (isset($data['unit_id']) || isset($data['title'])) {

            if (isset($data['main_image'])) {
                $data['main_image'] = $this->saveImage($data['main_image'], 'units');
            }

            $unit = $this->unitService->storeUnit($data);

            if (isset($data['features'])) {
                $this->unitFeaturesRepo->updateOrCreateDataOfUnit($data['features'], $unit->id, Feature::class, UnitFeatures::class, 'feature_id');
            }

            if (array_key_exists('images', $data)) {
                $this->saveImages($data['images'], $unit, 'units');
            }

            $response['unit'] = $unit ?? [];
        }

        return $response;
    }

    public function show(string $id)
    {
        $filters = ['id' => $id];

        // إعداد العلاقات بناءً على نوع المستخدم
        if (Auth::guard('api_admin')->check()) {
            $with = [
                'units.images', 'units.features',
                'location.direction',
                'user:id,first_name,last_name,company_name,about,phone,is_verified,image,ide,commercial_registration',
            ];

            $property = $this->propertyRepo->getObject(filters: $filters, with: $with);
        } elseif (Auth::guard('api_tenant')->check()) {
            $property = Property::with([
                'units' => function ($q) {
                    $q->where('status', 'active')->with(['images', 'features']);
                },
                'location.direction',
                'user:id,first_name,last_name,company_name,about',
            ])
                ->where('id', $id)
                ->first();
        } elseif (Auth::guard('api')->check()) {
            $property = Property::with([
                'units',
                'location.direction',
                'user',
            ])
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();
        } else {
            $property = Property::with([
                'units' => function ($q) {
                    $q->where('status', 'active')->with(['images', 'features']);
                },
                'location.direction',
                'user:id,first_name,last_name,company_name,about',
            ])
                ->where('id', $id)
                ->first();
        }

        if (!$property) {
            abort(404, 'Property not found');
        }

        return $property;
    }

    public function configHome(): array
    {
        $response = [];
        $response['categories'] = $this->categoryService->index(status: 'active');
        $response['features'] = $this->featureService->index(status: 'active');
        return $response;
    }
}
