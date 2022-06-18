<?php


use App\Models\Category;

class CategoryService
{

    public function GetCategoriesWithChild()
    {
        $categories = Category::whereNull('parent_id')
            ->with('childrenCategories')
//            ->where('is_deleted',0)
//            //->orderBy('priority','asc')
            ->get();
        return $categories;
    }

    public function ParentCategories()
    {
        return Category::where('parent_id',null)->where('is_deleted',0)->orderBy('priority','asc')->get();
    }
    public static function toggleHide($request)
    {
        return Category::where('id',$request->id)->update(['is_deleted'=>$request->hide]) ;
    }


    public static function destroy($keys = null)
    {
        return Category::where('id',$keys)->update(['is_deleted'=>1]) ;
    }

    public function GetProductsByCategory($slug)
    {

        return Category::with('products')->where('categories.slug',$slug)->first();
    }

    /****************************
     * private Methods area
     *****************************/
    private function GetParentId($parentID)
    {
        return isset($parentID['parent_id'])?$parentID['parent_id']:NULL;

    }
}