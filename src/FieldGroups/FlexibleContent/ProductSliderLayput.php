<?php

namespace MMM\FieldGroups\FlexibleContent;

class ProductSliderLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'product-slider';
  }

  protected function getLabel(): string
  {
    return 'Product Slider';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addText('heading', [
        'label' => 'Header Name',
        'instructions' => 'e.g. "Trending Supplements"',
        'required' => true,
      ])

      ->addTab('Products')
      ->addTaxonomy('category', [
        'label' => 'Product Category',
        'instructions' => 'Products are pulled automatically from this category.',
        'taxonomy' => 'product_cat',
        'field_type' => 'select',
        'allow_null' => false,
        'return_format' => 'id',
      ])
      ->addNumber('count', [
        'label' => 'Number of Products',
        'default_value' => 8,
        'min' => 1,
        'max' => 20,
      ])
      ->addSelect('order_by', [
        'label' => 'Order By',
        'choices' => [
          'date' => 'Newest',
          'popularity' => 'Popularity (Best Selling)',
          'price' => 'Price',
          'title' => 'Name (A–Z)',
          'rand' => 'Random',
        ],
        'default_value' => 'date',
      ])
      ->addSelect('order', [
        'label' => 'Order Direction',
        'choices' => [
          'DESC' => 'Descending',
          'ASC' => 'Ascending',
        ],
        'default_value' => 'DESC',
      ])->conditional('order_by', '!=', 'rand');
  }
}