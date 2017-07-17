<?php

return [
  'standardContent' => [
      'name' => 'standardContent',
      'label' => 'Standard Content',
      'description' => 'Insert paragraph with image',
      'view' => 'standard-content',
      'model' => 'StandardContent'
  ],
  'twoColumnContent' => [
      'name' => 'twoColumnContent',
      'label' => 'Two Columns Content',
      'description' => 'Insert paragraphs with image in two columns',
      'view' => 'two-columns-content',
      'model' => 'TwoColumnsContent'
  ],
  'columns' => [
      'name' => 'columns',
      'label' => 'Columns',
      'description' => 'Insert a row with <i>n</i> columns',
      'view' => 'columns',
      'model' => 'Columns'
  ],
  'column' => [
      'name' => 'column',
      'label' => 'Column',
      'description' => 'Insert a columns',
      'view' => 'column',
      'model' => 'Column'
  ],
];