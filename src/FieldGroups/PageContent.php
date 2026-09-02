<?php

namespace MMM\FieldGroups;

use MMM\FieldGroups\FlexibleContent\{CampaignBannerLayout, CtaLayout, CtaTilesLayout, SpacerLayout, StatsLayout, TwoColumnLayout};
use MMM\Traits\HasFlexibleContent;

class PageContent extends BaseFieldGroup {
  use HasFlexibleContent;

  public function __construct()
  {
    $this->registerLayout( new TwoColumnLayout() );
    $this->registerLayout( new StatsLayout() );
    $this->registerLayout( new CtaLayout() );
    $this->registerLayout( new SpacerLayout() );
    $this->registerLayout( new CampaignBannerLayout() );
    $this->registerLayout( new CtaTilesLayout() );
  }

  public function getTitle(): string
  {
    return 'Page Content';
  }

  protected function getLocation(): array
  {
    return [
      [ 'post_type', '==', 'page' ]
    ];
  }

  protected function addFields(): void
  {
    $flexibleContent = $this->fields->addFlexibleContent( 'components',
      [
        'label' => __( 'Components', 'mcguinnessmedia' ),
        'button_label' => __( 'Add Component', 'mcguinnessmedia' ),
      ] );

    foreach ( $this->layouts as $layout ) {
      $builder = $layout->build();
      $config = $layout->getConfig();

      $flexibleContent->addLayout( $builder, $config );
    }

    $this->fields->setGroupConfig( 'menu_order', -1 );
    $this->fields->setGroupConfig( 'hide_on_screen', [ 'the_content' ] );
  }
}