<?php declare(strict_types = 1);

namespace MailPoet\Automation\Engine\Data;

if (!defined('ABSPATH')) exit;


use MailPoet\RuntimeException;

class AutomationTemplate {
  public const TYPE_DEFAULT = 'default';
  public const TYPE_FREE_ONLY = 'free-only';
  public const TYPE_PREMIUM = 'premium';
  public const TYPE_COMING_SOON = 'coming-soon';

  public const CATEGORY_WELCOME = 'welcome';
  public const CATEGORY_ABANDONED_CART = 'abandoned-cart';
  public const CATEGORY_REENGAGEMENT = 'reengagement';
  public const CATEGORY_WOOCOMMERCE = 'woocommerce';

  public const ALL_CATEGORIES = [
    self::CATEGORY_WELCOME,
    self::CATEGORY_ABANDONED_CART,
    self::CATEGORY_REENGAGEMENT,
    self::CATEGORY_WOOCOMMERCE,
  ];

  /** @var string */
  private $slug;

  /** @var string */
  private $category;

  /** @var string */
  private $name;

  /** @var string */
  private $description;

  /** @var callable(): Automation */
  private $automationFactory;

  /** @var string */
  private $type;

  /** @param callable(): Automation $automationFactory */
  public function __construct(
    string $slug,
    string $category,
    string $name,
    string $description,
    callable $automationFactory,
    string $type = self::TYPE_DEFAULT
  ) {
    if (!in_array($category, self::ALL_CATEGORIES)) {
      throw new RuntimeException("$category is not a valid category.");
    }
    $this->slug = $slug;
    $this->category = $category;
    $this->name = $name;
    $this->description = $description;
    $this->automationFactory = $automationFactory;
    $this->type = $type;
  }

  public function getSlug(): string {
    return $this->slug;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getCategory(): string {
    return $this->category;
  }

  public function getType(): string {
    return $this->type;
  }

  public function getDescription(): string {
    return $this->description;
  }

  public function createAutomation(): Automation {
    return ($this->automationFactory)();
  }

  public function toArray(): array {
    return [
      'slug' => $this->getSlug(),
      'name' => $this->getName(),
      'category' => $this->getCategory(),
      'type' => $this->getType(),
      'description' => $this->getDescription(),
    ];
  }
}
