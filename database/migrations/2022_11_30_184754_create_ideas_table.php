<?php

use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Status::class)->default(1)->constrained();
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('votes_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
    }
};
