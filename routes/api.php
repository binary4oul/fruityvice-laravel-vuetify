<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['guest:api']], function() {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('login/refresh', 'Auth\LoginController@refresh');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('register', 'Auth\RegisterController@register');
});

Route::group(['middleware' => ['jwt']], function() {
    Route::post('person', 'LeadController@create');
    Route::put('person/{id}', 'PersonController@update');
    Route::get('leads/{active}', 'ProjectController@leads');

    Route::post('project', 'ProjectController@create');
    Route::post('projects', 'ProjectController@list');
    Route::get('project/{id}', 'ProjectController@show');
    Route::put('project/{id}', 'ProjectController@update');
    Route::delete('project/{id}', 'ProjectController@destroy');

    Route::post('projectdetail', 'ProjectDetailController@create');
    Route::put('projectdetail/{id}', 'ProjectDetailController@update');
    Route::get('projectdetail/{id}', 'ProjectDetailController@show');
    Route::delete('projectdetail/{id}', 'ProjectDetailController@destroy');

    Route::post('project/note', 'ProjectNoteController@create');
    Route::get('project/note/list/{projectid}', 'ProjectNoteController@list');
    Route::put('project/note/{id}', 'ProjectNoteController@update');
    Route::delete('project/note/{id}', 'ProjectNoteController@destroy');

    Route::post('project/image', 'ProjectImageController@create');
    Route::get('project/image/list/{projectid}', 'ProjectImageController@list');
    Route::put('project/image/{id}', 'ProjectImageController@update');
    Route::delete('project/image/{id}', 'ProjectImageController@destroy');

    Route::get('phonetype', 'PhoneController@getPhoneType');
    Route::post('phone', 'PhoneController@create');
    Route::put('phone/{id}', 'PhoneController@update');
    Route::delete('phone/{id}', 'PhoneController@destroy');

    Route::get('addresstype', 'AddressController@getAddressType');
    Route::get('states', 'AddressController@getStates');
    Route::post('address', 'AddressController@create');
    Route::put('address/{id}', 'AddressController@update');
    Route::delete('address/{id}', 'AddressController@destroy');

    Route::post('color', 'ColorController@create');
    Route::put('color/{id}', 'ColorController@update');
    Route::delete('color/{id}', 'ColorController@destroy');
    Route::get('colors', 'ColorController@list');

    Route::post('pattern', 'PatternController@create');
    Route::put('pattern/{id}', 'PatternController@update');
    Route::delete('pattern/{id}', 'PatternController@destroy');
    Route::get('patterns', 'PatternController@list');

    Route::post('ingredient', 'IngredientController@create');
    Route::get('ingredient/{id}', 'IngredientController@show');
    Route::put('ingredient/{id}', 'IngredientController@update');
    Route::delete('ingredient/{id}', 'IngredientController@destroy');
    Route::get('ingredients', 'IngredientController@list');

    Route::post('system', 'SystemController@create');
    Route::put('system/{id}', 'SystemController@update');
    Route::get('system/{id}', 'SystemController@show');
    Route::delete('system/{id}', 'SystemController@destroy');
    Route::get('systems', 'SystemController@list');

    Route::post('team', 'TeamController@create');
    Route::get('myteam', 'TeamController@getMyTeam');
    Route::put('myteam/{id}', 'TeamController@updateMyTeam');
    Route::post('myteam/member', 'TeamController@addNewMember');
    Route::put('myteam/member/{id}', 'TeamController@updateMember');
    Route::delete('myteam/member/{id}', 'TeamController@deleteMember');

    Route::put('team/{id}', 'TeamController@update');
    Route::get('teams', 'TeamController@getTeamList');
    Route::get('team/project/{id}', 'TeamController@getTeamProjects');


    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('me', 'Auth\LoginController@me');
    Route::put('profile', 'ProfileController@update');
    Route::post('membership', 'MembershipController@updateMembership');

    Route::post('calendar', 'CalendarController@create');
    Route::put('calendar/{id}', 'CalendarController@update');
    Route::delete('calendar/{id}', 'CalendarController@destroy');
    Route::get('calendars', 'CalendarController@list');

    Route::post('contracttemplate', 'ContractTemplateController@create');
    Route::put('contracttemplate/{id}', 'ContractTemplateController@update');
    Route::get('contracttemplate/list', 'ContractTemplateController@list');
    Route::get('contracttemplate/{id}', 'ContractTemplateController@show');
    Route::delete('contracttemplate/{id}', 'ContractTemplateController@destroy');

    Route::post('sendestimate', 'MailController@sendmail');

});

