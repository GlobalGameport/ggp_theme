<?php

/**
 * USAGE:
 * 1 - To use this file replace "adaptivetheme_subtheme" with the name of
 *     your theme in the function below.
 * 2 - Set 'style_enable_schemes' to 'on' in your themes info file (its near the bottom of that file).
 * 2 - Build or un-comment the forms. The Style Schemes form is ready to use,
 *     just un-comment it.
 */

// Replace 'adaptivetheme_subtheme' with your themes name, eg:
// function your_themes_name_form_system_theme_settings_alter(&$form, &$form_state)
function ggp_theme_form_system_theme_settings_alter(&$form, &$form_state)  {
  // General "alters" use a form id. Settings should not be set here. The only
  // thing useful about this is if you need to alter the form for the running
  // theme and *not* the theme setting.
  if (isset($form_id)) {
    return;
  }


 
  // Layout settings
  $form['gt'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => -10,
    '#default_tab' => 'defaults',
    '#attached' => array(
      'css' => array(drupal_get_path('theme', 'adaptivetheme') . '/css/at.settings.form.css'),
    ),
  );


  // bigscreen
  $form['gt']['bigscreen'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Layout'),
    '#description' => t('<h3>Standard Layout</h3><p>The standard layout is for desktops, laptops and other large screen devices.'),
    '#attributes' => array(
      'class' => array('at-layout-form'),
    ),
  );
  $form['gt']['bigscreen']['header_image'] = array(
    '#type' => 'file',
    '#title' => t('Header image'),
    '#maxlength' => 40,
  );
  $form['gt']['bigscreen']['header_image_path'] = array(
    '#type' => 'value',
    '#value' => !empty($settings['header_image_path']) ?
      $settings['header_image_path'] : '',
  );
  if (!empty($settings['gt']['bigscreen']['header_image_path'])) {
    $form['gt']['bigscreen']['header_image_preview'] = array(
      '#type' => 'markup',
      '#value' => !empty($settings['gt']['bigscreen']['header_image_path']) ?
          theme('image', $settings['gt']['bigscreen']['header_image_path']) : '',
    );
  }
  $form['gt']['bigscreen']['media-queries-wrapper'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Screen Media Queries'),
    '#weight' => 1,
    '#attributes' => array(
      'class' => array('at-media-queries'),
    ),
  );
  $form['gt']['bigscreen']['media-queries-wrapper']['bigscreen_media_query'] = array(
    '#type' => 'textfield',
    '#title' => t('Media query for this Background'),
    '#default_value' => theme_get_setting('bigscreen_media_query'),
    '#description' => t('Do not include @media, its included automatically.'),
    '#field_prefix' => '@media',
    '#size' => 100,
    '#required' => TRUE
  );
  // bigscreen
  $form['gt']['midscreen'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Layout'),
    '#description' => t('<h3>Standard Layout</h3><p>The standard layout is for desktops, laptops and other large screen devices.'),
    '#attributes' => array(
      'class' => array('at-layout-form'),
    ),
  );
  $form['gt']['midscreen']['header_image'] = array(
    '#type' => 'file',
    '#title' => t('Header image'),
    '#maxlength' => 40,
  );
  $form['gt']['midscreen']['header_image_path'] = array(
    '#type' => 'value',
    '#value' => !empty($settings['header_image_path']) ?
      $settings['header_image_path'] : '',
  );
  if (!empty($settings['gt']['midscreen']['header_image_path'])) {
    $form['gt']['midscreen']['header_image_preview'] = array(
      '#type' => 'markup',
      '#value' => !empty($settings['gt']['bigscreen']['header_image_path']) ?
          theme('image', $settings['gt']['bigscreen']['header_image_path']) : '',
    );
  }
  $form['gt']['midscreen']['media-queries-wrapper'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Screen Media Queries'),
    '#weight' => 1,
    '#attributes' => array(
      'class' => array('at-media-queries'),
    ),
  );
  $form['gt']['midscreen']['media-queries-wrapper']['bigscreen_media_query'] = array(
    '#type' => 'textfield',
    '#title' => t('Media query for this Background'),
    '#default_value' => theme_get_setting('bigscreen_media_query'),
    '#description' => t('Do not include @media, its included automatically.'),
    '#field_prefix' => '@media',
    '#size' => 100,
    '#required' => TRUE
  );

  $form['#submit'][] = 'ggp_theme_settings_submit'; 
  return $form;
}
/**
 * Save settings data.
 */
function ggp_theme_settings_submit($form, &$form_state) {
  $settings = array();

  // Update image field
  foreach ($form_state['input']['images'] as $image) {
    if (is_array($image)) {
      $image = $image['image'];
      
      if ($image['image_delete']) {
        // Delete banner file
        file_unmanaged_delete($image['image_path']);
        // Delete banner thumbnail file
        file_unmanaged_delete($image['image_thumb']);
      } else {
        // Update image
        $settings[] = $image;
      }
    }
  }
  
  // Check for a new uploaded file, and use that if available.
  if ($file = file_save_upload('image_upload')) {
    $file->status = FILE_STATUS_PERMANENT;
    //if ($image = _marinelli_save_image($file)) {
      // Put new image into settings
     // $settings[] = $image;
    //}
  }
}
