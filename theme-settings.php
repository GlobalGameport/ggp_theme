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


  // High Res
  $form['gt']['hd'] = array(
    '#type' => 'fieldset',
    '#title' => t('HD Res'),
    '#description' => t('<h3>Standard Layout</h3><p>The huge layout is for HD resolutions.'),
    '#attributes' => array(
      'class' => array('at-layout-form'),
    ),
  );
  $form['gt']['hd']['image'] = array(
    '#type' => 'fieldset',
    '#title' => t('Background Image'),
    '#description' => t('Background Image.'),
    );
  $form['gt']['hd']['image']['HD_header_image'] = array(
    '#type' => 'file',
    '#title' => t('Header image'),
    '#maxlength' => 40,
  );
  $form['gt']['hd']['image']['HD_header_image_path'] = array(
    '#type' => 'value',
    '#value' => !empty($settings['gt']['hd']['image']['HD_header_image_path']) ?
      $settings['gt']['hd']['image']['HD_header_image_path'] : '',
  );
  if (!empty($settings['gt']['hd']['image']['HD_header_image_path'])) {
    $form['gt']['hd']['image']['HD_header_image_preview'] = array(
      '#type' => 'markup',
      '#value' => !empty($settings['gt']['hd']['HD_header_image_path']) ?
          theme('image', $settings['gt']['hd']['HD_header_image_path']) : '',
    );
  }
  $form['gt']['hd']['media-queries-wrapper'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Screen Media Queries'),
    '#weight' => 1,
    '#attributes' => array(
      'class' => array('at-media-queries'),
    ),
  );
  $form['gt']['hd']['media-queries-wrapper']['HD_media_query'] = array(
    '#type' => 'textfield',
    '#title' => t('Media query for this Background'),
    '#default_value' => (theme_get_setting('HD_media_query') != NULL) ? theme_get_setting('HD_media_query') :  "only screen and (min-width:1200px)",
    '#description' => t('Do not include @media, its included automatically.'),
    '#field_prefix' => '@media',
    '#size' => 100,
    '#required' => TRUE
  );
  // Low Res
  $form['gt']['ld'] = array(
    '#type' => 'fieldset',
    '#title' => t('Low Res'),
    '#description' => t('<h3>Standard Layout</h3><p>The Low Res for Low Res.'),
    '#attributes' => array(
      'class' => array('at-layout-form'),
    ),
  );
  $form['gt']['ld']['image'] = array(
    '#type' => 'fieldset',
    '#title' => t('Background Image'),
    '#description' => t('Background Image.'),
    );
  $form['gt']['ld']['image']['LD_header_image'] = array(
    '#type' => 'file',
    '#title' => t('Header image'),
    '#maxlength' => 40,
  );
  $form['gt']['ld']['image']['LD_header_image_path'] = array(
    '#type' => 'value',
    '#value' => !empty($settings['gt']['ld']['image']['LD_header_image_path']) ?
      $settings['gt']['ld']['image']['LD_header_image_path'] : '',
  );
  if (!empty($settings['gt']['ld']['image']['LD_header_image_path'])) {
    $form['gt']['ld']['image']['LD_header_image_preview'] = array(
      '#type' => 'markup',
      '#value' => !empty($settings['gt']['ld']['LD_header_image_path']) ?
          theme('image', $settings['gt']['ld']['LD_header_image_path']) : '',
    );
  }
  $form['gt']['ld']['media-queries-wrapper'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard Screen Media Queries'),
    '#weight' => 1,
    '#attributes' => array(
      'class' => array('at-media-queries'),
    ),
  );
  $form['gt']['ld']['media-queries-wrapper']['LD_media_query'] = array(
    '#type' => 'textfield',
    '#title' => t('Media query for this Background'),
    '#default_value' => (theme_get_setting('LD_media_query') != NULL) ? theme_get_setting('LD_media_query') : "only screen and (max-width:1200px)" ,
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
  $values = $form_state['values'];
  debug($form_state);
  
  // Check for a new uploaded file, and use that if available.
  if ($file = file_save_upload('HD_header_image')) {
    $file->status = FILE_STATUS_PERMANENT;
    if ($image = _ggp_theme_save_image($file)) {
      // Put new image into settings
      $settings[] = $image;
    }
  }
  if ($file = file_save_upload('LD_header_image')) {
    $file->status = FILE_STATUS_PERMANENT;
    if ($image = _ggp_theme_save_image($file)) {
      // Put new image into settings
      $settings[] = $image;
    }
  }
  debug($settings);

  $comment        = "/* HD Background */\n";
  $path = $values['HD_header_image_path'];
  $media_query = $values['HD_media_query'];

  $style = "\n" . 'body {background:repeat-no url(' . $path . ');}';
  $css = $comment . '@media ' . $media_query . ' {' . "\n" . $style . "\n" . '}';
  $layouts[] = check_plain($css);

  $comment        = "/* LD Background */\n";
  $path = $values['LD_header_image_path'];
  $media_query = $values['LD_media_query'];

  $style = "\n" . 'body {background:repeat-no url(' . $path . ');}';
  $css = $comment . '@media ' . $media_query . ' {' . "\n" . $style . "\n" . '}';
  $layouts[] = check_plain($css);


  $theme = $form_state['build_info']['args'][0];
  $path  = "public://at_css";
  file_prepare_directory($path, FILE_CREATE_DIRECTORY);


  $file  = $theme . '.responsive.background.css';
  $data  = $layout_data;
  $filepath = $path . '/' . $file;
  file_save_data($data, $filepath, FILE_EXISTS_REPLACE);

  variable_set($theme . '_responsive_background_file_path', $path);
  variable_set($theme . '_responsive_background_file_css', $file);
}


function _ggp_theme_save_image($file, $bg_folder = 'public://backgrounds/', $bg_thumb_folder = 'public://backgrounds/thumb/') {
  file_prepare_directory($bg_folder, FILE_CREATE_DIRECTORY);
  file_prepare_directory($bg_thumb_folder, FILE_CREATE_DIRECTORY);

   $parts = pathinfo($file->filename);
  $destination = $bg_folder . $parts['basename'];
  $setting = array();

  $file->status = FILE_STATUS_PERMANENT;
  
  // Copy temporary image into banner folder
  if ($img = file_copy($file, $destination, FILE_EXISTS_REPLACE)) {
    // Generate image thumb
    $image = image_load($destination);
    $small_img = image_scale($image, 300, 100);
    $image->source = $bg_thumb_folder . $parts['basename'];
    image_save($image);

    // Set image info
    $setting['image_path'] = $destination;

    return $setting;
  }
  
  return FALSE;
}