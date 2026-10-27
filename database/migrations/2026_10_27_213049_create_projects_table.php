<?php

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('title');
            $table->text('client')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->text('summary')->nullable();
            $table->text('challenge')->nullable();
            $table->text('work')->nullable();
            $table->text('result')->nullable();
            $table->string('cover')->nullable();
            $table->json('gallery')->nullable();
            $table->metaFields();
            $table->timestamps();
        });

        Schema::create('project_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_tag');
        Schema::dropIfExists('projects');
    }
};
