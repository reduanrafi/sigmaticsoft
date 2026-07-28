<?php

namespace App\Http\Controllers\Api\V1\BedtimeStories;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\BedtimeStories\BedtimeCategoryResource;
use App\Http\Resources\Api\V1\BedtimeStories\BedtimeStoryResource;
use App\Http\Resources\Api\V1\BedtimeStories\BedtimeProgressResource;
use App\Http\Requests\Api\V1\BedtimeStories\UpdateProgressRequest;
use App\Models\BedtimeStories\BedtimeCategory;
use App\Models\BedtimeStories\BedtimeStory;
use App\Models\BedtimeStories\BedtimeProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoryController extends BaseApiController
{
    /**
     * GET /api/v1/categories
     */
    public function categories(): JsonResponse
    {
        $categories = BedtimeCategory::all();
        return $this->sendResponse(BedtimeCategoryResource::collection($categories), 'Categories fetched successfully');
    }

    /**
     * GET /api/v1/stories
     */
    public function index(Request $request): JsonResponse
    {
        $query = BedtimeStory::query()->with('category');

        if ($request->has('categoryId')) {
            $query->where('category_id', $request->categoryId);
        }

        if ($request->has('ageGroup')) {
            $query->where('age_group', $request->ageGroup);
        }

        $stories = $query->paginate($request->get('per_page', 10));

        // Populate is_favorite for authenticated users
        if (auth('sanctum')->check()) {
            $favoriteIds = auth('sanctum')->user()->storyFavorites()->pluck('story_id')->toArray();
            foreach ($stories->items() as $story) {
                $story->is_favorite = in_array($story->id, $favoriteIds);
            }
        }

        return $this->sendResponse(BedtimeStoryResource::collection($stories)->response()->getData(true), 'Stories fetched successfully');
    }

    /**
     * GET /api/v1/stories/{id}
     */
    public function show($id): JsonResponse
    {
        $story = BedtimeStory::with('category')->find($id);

        if (!$story) {
            return $this->sendError('Story not found');
        }

        // Add user-specific favorite status if authenticated
        if (auth('sanctum')->check()) {
            $story->is_favorite = auth('sanctum')->user()->storyFavorites()->where('story_id', $id)->exists();
        }

        return $this->sendResponse(new BedtimeStoryResource($story), 'Story fetched successfully');
    }

    /**
     * GET /api/v1/stories/recommended
     */
    public function recommended(): JsonResponse
    {
        $stories = BedtimeStory::with('category')->inRandomOrder()->limit(5)->get();
        return $this->sendResponse(BedtimeStoryResource::collection($stories), 'Recommended stories fetched successfully');
    }

    /**
     * POST /api/v1/stories/{id}/favorite
     */
    public function toggleFavorite($id): JsonResponse
    {
        $story = BedtimeStory::find($id);
        if (!$story) {
            return $this->sendError('Story not found');
        }

        $user = auth('sanctum')->user();
        $isFavorited = $user->storyFavorites()->toggle($id);

        $status = count($isFavorited['attached']) > 0 ? 'added to' : 'removed from';
        return $this->sendResponse(null, "Story $status favorites");
    }

    /**
     * GET /api/v1/user/favorites
     */
    public function favorites(): JsonResponse
    {
        $favorites = auth('sanctum')->user()->storyFavorites()->with('category')->get();
        
        $favorites->each(function($story) {
            $story->is_favorite = true;
        });

        return $this->sendResponse(BedtimeStoryResource::collection($favorites), 'User favorites fetched successfully');
    }

    /**
     * POST /api/v1/stories/{id}/progress
     */
    public function updateProgress(UpdateProgressRequest $request, $id): JsonResponse
    {
        $story = BedtimeStory::find($id);
        if (!$story) {
            return $this->sendError('Story not found');
        }

        $progress = BedtimeProgress::updateOrCreate(
            ['user_id' => auth('sanctum')->id(), 'story_id' => $id],
            ['progress' => $request->progress]
        );

        return $this->sendResponse(new BedtimeProgressResource($progress), 'Story progress updated');
    }

    /**
     * GET /api/v1/user/history
     */
    public function history(): JsonResponse
    {
        $user = auth('sanctum')->user();
        $history = $user->storyProgress()->with('story.category')->orderBy('updated_at', 'desc')->get();
        
        $favoriteIds = $user->storyFavorites()->pluck('story_id')->toArray();
        
        $history->each(function($progress) use ($favoriteIds) {
            if ($progress->story) {
                $progress->story->is_favorite = in_array($progress->story->id, $favoriteIds);
            }
        });

        return $this->sendResponse(BedtimeProgressResource::collection($history), 'User story history fetched successfully');
    }
}
