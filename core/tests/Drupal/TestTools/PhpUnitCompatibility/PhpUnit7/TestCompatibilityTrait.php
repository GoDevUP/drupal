<?php

namespace Drupal\TestTools\PhpUnitCompatibility\PhpUnit7;

/**
 * Makes Drupal's test API forward compatible with multiple versions of PHPUnit.
 */
trait TestCompatibilityTrait {

  /**
   * @todo deprecate this method override in
   *   https://www.drupal.org/project/drupal/issues/2742585
   *
   * @see \Drupal\simpletest\TestBase::assertTrue()
   */
  public static function assertTrue($actual, string $message = ''): void {
    if (is_bool($actual)) {
      parent::assertTrue($actual, $message);
    }
    else {
      @trigger_error('Support for asserting against non-boolean values in ::assertTrue is deprecated in drupal:8.8.0 and is removed from drupal:9.0.0. Use a different assert method, for example, ::assertNotEmpty(). See https://www.drupal.org/node/3082086', E_USER_DEPRECATED);
      parent::assertNotEmpty($actual, $message);
    }
  }

  /**
   * @todo deprecate this method override in
   *   https://www.drupal.org/project/drupal/issues/2742585
   *
   * @see \Drupal\simpletest\TestBase::assertFalse()
   */
  public static function assertFalse($actual, string $message = ''): void {
    if (is_bool($actual)) {
      parent::assertFalse($actual, $message);
    }
    else {
      @trigger_error('Support for asserting against non-boolean values in ::assertFalse is deprecated in drupal:8.8.0 and is removed from drupal:9.0.0. Use a different assert method, for example, ::assertEmpty(). See https://www.drupal.org/node/3082086', E_USER_DEPRECATED);
      parent::assertEmpty($actual, $message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function assertEquals($expected, $actual, string $message = '', float $delta = 0, int $maxDepth = 10, bool $canonicalize = FALSE, bool $ignoreCase = FALSE): void {
    // Cast objects implementing MarkupInterface to string instead of
    // relying on PHP casting them to string depending on what they are being
    // comparing with.
    if (method_exists(self::class, 'castSafeStrings')) {
      $expected = self::castSafeStrings($expected);
      $actual = self::castSafeStrings($actual);
    }
    parent::assertEquals($expected, $actual, $message, $delta, $maxDepth, $canonicalize, $ignoreCase);
  }

  /**
   * Forward compatibility for assertEqualsCanonicalizing.
   */
  public static function assertEqualsCanonicalizing($expected, $actual, string $message = ''): void {
    static::assertEquals($expected, $actual, $message, 0.0, 10, TRUE);
  }

  /**
   * Forward compatibility for assertNotEqualsCanonicalizing.
   */
  public static function assertNotEqualsCanonicalizing($expected, $actual, string $message = ''): void {
    static::assertNotEquals($expected, $actual, $message, 0.0, 10, TRUE);
  }

  /**
   * Forward compatibility for assertStringContainsString.
   */
  public static function assertStringContainsString(string $needle, string $haystack, string $message = ''): void {
    static::assertContains($needle, $haystack, $message);
  }

  /**
   * Forward compatibility for assertStringContainsStringIgnoringCase.
   */
  public static function assertStringContainsStringIgnoringCase(string $needle, string $haystack, string $message = ''): void {
    static::assertContains($needle, $haystack, $message, TRUE);
  }

  /**
   * Forward compatibility for assertStringNotContainsString.
   */
  public static function assertStringNotContainsString(string $needle, string $haystack, string $message = ''): void {
    static::assertNotContains($needle, $haystack, $message);
  }

  /**
   * Forward compatibility for assertStringNotContainsStringIgnoringCase.
   */
  public static function assertStringNotContainsStringIgnoringCase(string $needle, string $haystack, string $message = ''): void {
    static::assertNotContains($needle, $haystack, $message, TRUE);
  }

}
