<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Get unique categories from internships
        $categories = DB::table('internships')->distinct()->pluck('category');

        // 2. Insert into categories table if not exists
        foreach ($categories as $name) {
            DB::table('categories')->updateOrInsert(['name' => $name], ['created_at' => now(), 'updated_at' => now()]);
        }

        // 3. Add category_id to internships
        Schema::table('internships', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('category')->constrained('categories')->onDelete('set null');
        });

        // 4. Update category_id based on category string name
        $allCategories = DB::table('categories')->get();
        foreach ($allCategories as $cat) {
            DB::table('internships')
                ->where('category', $cat->name)
                ->update(['category_id' => $cat->id]);
        }

        // 5. Drop old category column
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->string('category')->after('city');
        });

        // Restore category names
        $internships = DB::table('internships')
            ->join('categories', 'internships.category_id', '=', 'categories.id')
            ->select('internships.id', 'categories.name')
            ->get();

        foreach ($internships as $i) {
            DB::table('internships')->where('id', $i->id)->update(['category' => $i->name]);
        }

        Schema::table('internships', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
