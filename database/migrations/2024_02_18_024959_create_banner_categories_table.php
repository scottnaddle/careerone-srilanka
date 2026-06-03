<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banner_categories', function (Blueprint $table) {
            // Sử dụng ULID làm khóa chính
            $table->ulid('id')->primary();
            $table->ulid('parent_id')->nullable(); // Khóa ngoại cho parent category
            $table->string('name'); // Tên danh mục
            $table->string('slug')->unique(); // Slug cho danh mục
            $table->longText('description')->nullable(); // Mô tả cho danh mục
            $table->boolean('is_active')->default(false); // Trạng thái kích hoạt
            $table->timestamps(); // Thời gian tạo và cập nhật
        });

        // Thêm ràng buộc ngoại cho trường parent_id
        Schema::table('banner_categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('banner_categories')
                ->onDelete('cascade'); // Xóa cascade nếu parent bị xóa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_categories', function (Blueprint $table) {
            // Xóa ràng buộc ngoại trước khi xóa bảng
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('banner_categories'); // Xóa bảng nếu tồn tại
    }
};
