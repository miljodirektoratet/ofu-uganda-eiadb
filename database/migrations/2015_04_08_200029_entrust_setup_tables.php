<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
  public function up()
  {
    // We need to upgrade from Entrust for Laravel 4. A lot of changes.
    
    // 1. Remove stuff we don't need.
    Schema::table('assigned_roles', function(Blueprint $table) {
      $table->dropForeign('assigned_roles_user_id_foreign');
      $table->dropForeign('assigned_roles_role_id_foreign');
    });
    Schema::table('permission_role', function(Blueprint $table) {
      $table->dropForeign('permission_role_permission_id_foreign');
      $table->dropForeign('permission_role_role_id_foreign');
    });
    Schema::drop('permission_role');
    Schema::drop('permissions');

    // 2. assigned_roles and roles are still needed.
    Schema::rename('roles', 'roles_temp');

    // 3. Create all tables from fresh.

    // Create table for storing roles
    Schema::create('roles', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->unique();
      $table->string('display_name')->nullable();
      $table->string('description')->nullable();
      $table->timestamps();
    });

      // Create table for associating roles to users (Many-to-Many)
    Schema::create('role_user', function (Blueprint $table) {
      $table->integer('user_id')->unsigned();
      $table->integer('role_id')->unsigned();

      $table->foreign('user_id')->references('id')->on('users')
          ->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('role_id')->references('id')->on('roles')
          ->onUpdate('cascade')->onDelete('cascade');

      $table->primary(['user_id', 'role_id']);
    });

    // Create table for storing permissions
    Schema::create('permissions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->unique();
      $table->string('display_name')->nullable();
      $table->string('description')->nullable();
      $table->timestamps();
    });

    // Create table for associating permissions to roles (Many-to-Many)
    Schema::create('permission_role', function (Blueprint $table) {
      $table->integer('permission_id')->unsigned();
      $table->integer('role_id')->unsigned();

      $table->foreign('permission_id')->references('id')->on('permissions')
          ->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('role_id')->references('id')->on('roles')
          ->onUpdate('cascade')->onDelete('cascade');

      $table->primary(['permission_id', 'role_id']);
    });

    // 4. Get data from old tables.
    $roles = DB::select('select * from roles_temp');
    foreach ($roles as $role) {    
      DB::insert('insert into roles (id, name, display_name, description, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', [$role->id, $role->name, $role->name2, $role->name2, $role->created_at, $role->updated_at]);
    }

    $assigneds = DB::select('select * from assigned_roles');
    foreach ($assigneds as $assigned) {    
      DB::insert('insert into role_user (user_id, role_id) values (?, ?)', [$assigned->user_id, $assigned->role_id]);
    }


    // 5. Drop old tables.
    Schema::drop('assigned_roles');
    Schema::drop('roles_temp');
  }

  /**
   * Reverse the migrations.
   *
   * @return  void
   */
  public function down()
  {
    // 1. Drop stuff we don't need.
    Schema::drop('permission_role');
    Schema::drop('permissions');

    // 2. role_user and roles are still needed.
    Schema::rename('roles', 'roles_temp');

    // 3. Create all tables (same as in 2014_06_03_No3_entrust_setup_tables.php).

    // Creates the roles table
    Schema::create('roles', function($table)
    {
      $table->increments('id')->unsigned();            
      $table->string('name')->unique();
      $table->string('name2', 255)->nullable();
      $table->timestamps();
    });

    // Creates the assigned_roles (Many-to-Many relation) table
    Schema::create('assigned_roles', function($table)
    {
      $table->increments('id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->integer('role_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users'); // assumes a users table
      $table->foreign('role_id')->references('id')->on('roles');
    });        

    // Creates the permissions table
    Schema::create('permissions', function($table)
    {
      $table->increments('id')->unsigned();
      $table->string('name');
      $table->string('display_name');
      $table->timestamps();
    });

    // Creates the permission_role (Many-to-Many relation) table
    Schema::create('permission_role', function($table)
    {
      $table->increments('id')->unsigned();
      $table->integer('permission_id')->unsigned();
      $table->integer('role_id')->unsigned();
      $table->foreign('permission_id')->references('id')->on('permissions'); // assumes a users table
      $table->foreign('role_id')->references('id')->on('roles');
    });

    // 4. Get data from old tables.
    $roles = DB::select('select * from roles_temp');
    foreach ($roles as $role) {    
      DB::insert('insert into roles (id, name, name2, created_at, updated_at) values (?, ?, ?, ?, ?)', [$role->id, $role->name, $role->display_name, $role->created_at, $role->updated_at]);
    }

    $assigneds = DB::select('select * from role_user');
    foreach ($assigneds as $assigned) {    
      DB::insert('insert into assigned_roles (user_id, role_id) values (?, ?)', [$assigned->user_id, $assigned->role_id]);
    }

    // 5. Drop "old" tables.    
    Schema::drop('role_user');
    Schema::drop('roles_temp');
  }
}
