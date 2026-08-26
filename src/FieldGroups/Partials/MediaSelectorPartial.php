<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class MediaSelectorPartial extends BasePartial
{
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder('media_selector');

    $fields->addGroup('media')
      ->addRadio('type', [
        'label' => 'Media Type',
        'choices' => [
          'image' => 'Image',
          'slider' => 'Slider',
          'embed' => 'Embedded Video',
          'upload' => 'Uploaded Video',
        ]
      ])
      ->addImage('image', ['required' => true])->conditional('type', '==', 'image')
      ->addGallery('gallery')->conditional('type', '==', 'slider')
      ->addOembed('embed', [
        'label' => 'Video URL',
        'instructions' => 'Paste a YouTube, Vimeo, or other oEmbed-compatible URL',
        'required' => true
      ])->conditional('type', '==', 'embed')
      ->addRepeater('upload')->conditional('type', '==', 'upload')
      ->addFile('file', [
        'label' => 'Video File',
        'required' => true,
        'mime_types' => 'mp4,webm,ogv',
        'return_format' => 'array',
      ])
      ->addText('media_query', [
        'label' => 'Media Query',
        'instructions' => 'e.g. (min-width: 1024px) for desktop-only sources',
        'placeholder' => '(min-width: 768px)',
      ])
      ->addText('label', [
        'label' => 'Source Label',
        'instructions' => 'Helpful label like "Desktop HD" or "Mobile',
        'placeholder' => 'Desktop HD'
      ])
      ->endRepeater()
      ->addImage('upload_poster', [
        'label' => 'Video Poster',
        'instructions' => 'Thumbnail shown before video plays',
      ])->conditional('type', '==', 'upload')
      ->endGroup();

    return $fields;
  }
}