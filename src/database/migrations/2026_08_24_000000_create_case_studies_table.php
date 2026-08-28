<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('tag')->nullable();
            $table->string('icon_class')->nullable();
            $table->text('excerpt')->nullable();
            
            // Left side contents
            $table->text('client_context')->nullable();
            $table->text('existing_environment')->nullable();
            $table->text('business_problem')->nullable();
            $table->text('solution')->nullable();
            
            // System Architecture Flowchart Nodes (3 nodes)
            $table->string('node1_title')->nullable();
            $table->string('node1_desc')->nullable();
            $table->string('node2_title')->nullable();
            $table->string('node2_desc')->nullable();
            $table->string('node3_title')->nullable();
            $table->string('node3_desc')->nullable();
            
            // Post Flowchart details
            $table->text('implementation')->nullable();
            $table->text('outcome')->nullable();
            $table->text('lessons_learned')->nullable();
            
            // Sidebar details
            $table->string('category')->nullable();
            $table->string('timeline')->nullable();
            $table->string('stack')->nullable();
            $table->string('status')->nullable();
            
            // Capabilities (4 bullets)
            $table->string('capability_1')->nullable();
            $table->string('capability_2')->nullable();
            $table->string('capability_3')->nullable();
            $table->string('capability_4')->nullable();
            
            // CTA
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_link')->nullable();
            
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(0);
            
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
        Schema::dropIfExists('case_studies');
    }
};
