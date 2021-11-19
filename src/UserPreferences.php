<?php

namespace YiddisheKop\UserPreferences;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use DB;

class UserPreferences {

  protected static $preferences;

  protected static $hasLoaded;

  protected static $userId;

  protected static function load() {

    if (self::$hasLoaded) {
      return;
    }

    self::loadPreferences();
  }

  protected static function getUserId() {
    return self::$userId ?? Auth::id();
  }

  protected static function loadPreferences() {

    $data = DB::table(config('user-preferences.database.table'))
      ->select(config('user-preferences.database.column'))
      ->where(config('user-preferences.database.primary_key'), '=', self::getUserId())
      ->first();

    $preferences = json_decode($data->{config('user-preferences.database.column')});

    if (json_last_error() !== JSON_ERROR_NONE) {
      self::$preferences = (object) config('user-preferences.defaults');
      return;
    }

    self::$preferences = $preferences;
    self::$hasLoaded = true;
  }

  /**
   * Set the user
   *
   * Default is authenticated user
   */
  public static function for($user): self {
    $id = is_numeric($user) ? $user : $user->id;
    self::$userId = $id;
    return new static;
  }

  /**
   * Get the default preferences
   */
  public static function
  default() {
    return (object) config('user-preferences.defaults');
  }

  /**
   * Get preference by key
   *
   * returns defaults if not set on the user
   */
  public static function get(string $key, $default = null) {
    self::load();
    return Arr::get(
      (array) self::$preferences,
      $key,
      Arr::get(config('user-preferences.defaults'), $key, $default)
    );
  }

  /**
   * Set a preference by key
   */
  public static function set(string $key, $value): self {
    self::load();
    self::$preferences->{$key} = $value;
    self::save();
    return new static;
  }

  /**
   * Update multiple preferences at once
   */
  public static function update(array $prefs): self {
    self::load();
    foreach ($prefs as $key => $value) {
      self::$preferences->{$key} = $value;
    }
    self::save();
    return new static;
  }

  /**
   * Reset preferences to defaults
   */
  public static function reset(string $key): self {
    self::load();

    if (!isset($key)) {
      self::$preferences = (object) config('user-preferences.defaults');
      self::save();
      return new static;
    }

    if ($default = config('user-preferences.defaults.' . $key)) {
      self::$preferences->{$key} = $default;
    } else {
      unset(self::$preferences->{$key});
    }

    self::save();
    return new static;
  }

  /**
   * Check if a key exists in the preferences
   */
  public static function has(string $key): bool {
    self::load();
    return Arr::has((array) self::$preferences, $key);
  }

  /**
   * Get all preferences
   */
  public static function all(): object {
    self::load();
    return self::$preferences;
  }


  /**
   * Save all preferences to database
   */
  protected static function save(): self {
    DB::table(config('user-preferences.database.table'))
      ->where(config('user-preferences.database.primary_key'), '=', self::getUserId())
      ->update([config('user-preferences.database.column') => json_encode(self::$preferences)]);
    return new static;
  }
}
