<?php

namespace MMM\FieldGroups;

use MMM\OptionsPages\ThemeOptions;

class ThemeOptionsFields extends BaseFieldGroup {
  protected function addFields(): void
  {
    $this->fields
      ->addImage( 'site_logo' )
      ->addGroup( 'contact_info' )
      ->addWysiwyg( 'address' )
      ->addText( 'phone' )
      ->addRepeater( 'socials' )
      ->addSelect( 'network', [
        'choices' => [
          'facebook' => 'Facebook',
          'twitter' => 'Twitter',
          'instagram' => 'Instagram',
          'youtube' => 'Youtube',
          'tiktok' => 'Tiktok',
        ]
      ] )
      ->addUrl( 'link', [ 'required' => true ] )
      ->endRepeater()
      ->endGroup()
      ->addTrueFalse( 'show_footer_credit', [
        'label' => 'Show Footer Credit',
        'default_value' => 1,
        'ui' => true,
      ] )
      ->addText( 'footer_credit_label', [
        'label' => 'Footer Credit Label',
        'default_value' => 'Powered by',
        'conditional_logic' => [
          [
            [
              'field' => 'show_footer_credit',
              'operator' => '==',
              'value' => '1',
            ],
          ],
        ],
      ] )
      ->addText( 'footer_credit_name', [
        'label' => 'Footer Credit Name',
        'default_value' => 'McGuinness Media & Marketing',
        'conditional_logic' => [
          [
            [
              'field' => 'show_footer_credit',
              'operator' => '==',
              'value' => '1',
            ],
          ],
        ],
      ] )
      ->addUrl( 'footer_credit_url', [
        'label' => 'Footer Credit URL',
        'default_value' => 'https://mcguinnessmedia.com/',
        'conditional_logic' => [
          [
            [
              'field' => 'show_footer_credit',
              'operator' => '==',
              'value' => '1',
            ],
          ],
        ],
      ] )
      ->addRepeater( 'analytics', [
        'button_label' => 'Add Provider',
      ] )
      ->addSelect( 'type', [
        'required' => true,
        'choices' => [
          'gtm' => 'Google Tag Manager',
          'ga4' => 'Google Analytics 4',
          'meta' => 'Meta Pixel',
        ],
        'default_choice' => 'gtm',
      ] )
      ->addText( 'id', [
        'label' => 'Analytics ID',
        'required' => true,
      ] )
      ->endRepeater();

  }

  protected function getTitle(): string
  {
    return 'Theme Options';
  }

  protected function getLocation(): array
  {
    return [
      [ 'options_page', '==', (new ThemeOptions())->getSlug() ]
    ];
  }
}