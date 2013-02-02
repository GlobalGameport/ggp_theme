<?php


// Include Google Fonts Stuff
include_once(drupal_get_path('theme', 'adaptivetheme') . '/inc/google.web.fonts.inc');

// Replace 'adaptivetheme_subtheme' with your themes name, eg:
// function your_themes_name_form_system_theme_settings_alter(&$form, &$form_state)
function ggp_theme_form_system_theme_settings_alter(&$form, &$form_state)  {
  // General "alters" use a form id. Settings should not be set here. The only
  // thing useful about this is if you need to alter the form for the running
  // theme and *not* the theme setting.
  if (isset($form_id)) {
    return;
  }
  // Css settings
  $form['at']['font'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fonts'),
    '#description' => t('<h3>Fonts</h3><p>Here you can set a default font which will style all text. You can also set unique fonts for the page title, site name and slogan, and fonts for node, comment and block titles. First select the font type (Websafe or Google web font), then select the font family. You can preview Google web fonts here: <a href="!link" target="_blank">http://www.google.com/webfonts</a></p>', array('!link' => 'http://www.google.com/webfonts')),
  );
  $form['at']['font']['base_font_wrapper'] = array (
    '#type' => 'fieldset',
    '#title' => t('Default font'),
    '#attributes' => array('class' => array('font-element-wrapper'))
  );
  $form['at']['font']['base_font_wrapper']['base_font_type'] = array (
    '#type' => 'select',
    '#title' => t('Type'),
    '#options' => array (
      '' => t('Websafe font'),
      'gwf' => t('Google font'),
    ),
    '#default_value' => theme_get_setting('base_font_type'),
  );
  $form ['at']['font']['base_font_wrapper']['base_font_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="base_font_type"]' => array (
          'value' => ''
        )
      )
    )
  );
  $form['at']['font']['base_font_wrapper']['base_font_container']['base_font'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('base_font'),
    '#options' => array(
      'bf-sss' => t('Trebuchet MS, Helvetica Neue, Arial, Helvetica, sans-serif'),
      'bf-ssl' => t('Verdana, Geneva, Arial, Helvetica, sans-serif'),
      'bf-a'   => t('Arial, Helvetica, sans-serif'),
      'bf-cc'  => t('Calibri, Candara, Arial, Helvetica, sans-serif'),
      'bf-m'   => t('Segoe UI, Myriad Pro, Myriad, Arial, Helvetica, sans-serif'),
      'bf-l'   => t('Lucida Sans Unicode, Lucida Sans, Lucida Grande, Verdana, Geneva, sans-serif'),
      'bf-ss'  => t('Garamond, Perpetua, Times New Roman, serif'),
      'bf-sl'  => t('Georgia, Baskerville, Palatino, Palatino Linotype, Book Antiqua, Times New Roman, serif'),
      'bf-ms'  => t('Consolas, Monaco, Courier New, Courier, monospace'),
    ),
  );
  $form ['at'] ['font']['base_font_wrapper']['base_font_gwf_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="base_font_type"]' => array (
          'value' => 'gwf'
        )
      )
    )
  );
  $form['at']['font']['base_font_wrapper']['base_font_gwf_container']['base_font_gwf'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('base_font_gwf'),
    '#options' => google_web_fonts_list_options(),
  );
  $form['at']['font']['page_title_font_wrapper'] = array (
    '#type' => 'fieldset',
    '#title' => t('Page Title'),
    '#attributes' => array('class' => array('font-element-wrapper'))
  );
  $form['at']['font']['page_title_font_wrapper']['page_title_font_type'] = array (
    '#type' => 'select',
    '#title' => t('Type'),
    '#options' => array (
      '' => t('Websafe font'),
      'gwf' => t('Google font'),
    ),
    '#default_value' => theme_get_setting('page_title_font_type')
  );
  $form['at']['font']['page_title_font_wrapper']['page_title_font_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="page_title_font_type"]' => array (
          'value' => ''
        )
      )
    )
  );
  $form['at']['font']['page_title_font_wrapper']['page_title_font_container']['page_title_font'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('page_title_font'),
    '#options' => array(
      'ptf-sss' => t('Candara, Trebuchet MS, Helvetica Neue, Arial, Helvetica, sans-serif'),
      'ptf-ssl' => t('Verdana, Geneva, Arial, Helvetica, sans-serif'),
      'ptf-a'   => t('Arial, Helvetica, sans-serif'),
      'ptf-cc'  => t('Calibri, Candara, Arial, Helvetica, sans-serif'),
      'ptf-m'   => t('Segoe UI, Myriad Pro, Myriad, Arial, Helvetica, sans-serif'),
      'ptf-l'   => t('Lucida Sans Unicode, Lucida Sans, Lucida Grande, Verdana, Geneva, sans-serif'),
      'ptf-ss'  => t('Garamond, Perpetua, Times New Roman, serif'),
      'ptf-sl'  => t('Georgia, Baskerville, Palatino, Palatino Linotype, Book Antiqua, Times New Roman, serif'),
      'ptf-ms'  => t('Consolas, Monaco, Courier New, Courier, monospace'),
    ),
  );
  $form['at']['font']['page_title_font_wrapper']['page_title_font_gwf_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="page_title_font_type"]' => array (
          'value' => 'gwf'
        )
      )
    )
  );
  $form['at']['font']['page_title_font_wrapper']['page_title_font_gwf_container']['page_title_font_gwf'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('page_title_font_gwf'),
    '#options' => google_web_fonts_list_options(),
  );
  // Node title font
  $form['at']['font']['node_title_font_wrapper'] = array (
    '#type' => 'fieldset',
    '#title' => t('Node Title'),
    '#attributes' => array('class' => array('font-element-wrapper'))
  );
  $form ['at']['font']['node_title_font_wrapper']['node_title_font_type'] = array (
    '#type' => 'select',
    '#title' => t('Type'),
    '#options' => array (
      '' => t('Websafe font'),
      'gwf' => t('Google font'),
    ),
    '#default_value' => theme_get_setting('node_title_font_type')
  );
  $form['at']['font']['node_title_font_wrapper']['node_title_font_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="node_title_font_type"]' => array (
          'value' => ''
        )
      )
    )
  );
  $form['at']['font']['node_title_font_wrapper']['node_title_font_container']['node_title_font'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('node_title_font'),
    '#options' => array(
      'ntf-sss' => t('Candara, Trebuchet MS, Helvetica Neue, Arial, Helvetica, sans-serif'),
      'ntf-ssl' => t('Verdana, Geneva, Arial, Helvetica, sans-serif'),
      'ntf-a'   => t('Arial, Helvetica, sans-serif'),
      'ntf-cc'  => t('Calibri, Candara, Arial, Helvetica, sans-serif'),
      'ntf-m'   => t('Segoe UI, Myriad Pro, Myriad, Arial, Helvetica, sans-serif'),
      'ntf-l'   => t('Lucida Sans Unicode, Lucida Sans, Lucida Grande, Verdana, Geneva, sans-serif'),
      'ntf-ss'  => t('Garamond, Perpetua, Times New Roman, serif'),
      'ntf-sl'  => t('Georgia, Baskerville, Palatino, Palatino Linotype, Book Antiqua, Times New Roman, serif'),
      'ntf-ms'  => t('Consolas, Monaco, Courier New, Courier, monospace'),
    ),
  );
  $form['at']['font']['node_title_font_wrapper']['node_title_font_gwf_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="node_title_font_type"]' => array (
          'value' => 'gwf'
        )
      )
    )
  );
  $form['at']['font']['node_title_font_wrapper']['node_title_font_gwf_container']['node_title_font_gwf'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('node_title_font_gwf'),
    '#options' => google_web_fonts_list_options(),
  );
  // Block title font
  $form ['at']['font'] ['block_title_font_wrapper'] = array (
    '#type' => 'fieldset',
    '#title' => t('Block Title'),
    '#attributes' => array('class' => array('font-element-wrapper'))
  );

  $form ['at']['font']['block_title_font_wrapper']['block_title_font_type'] = array (
    '#type' => 'select',
    '#title' => t('Type'),
    '#options' => array (
      '' => t('Websafe font'),
      'gwf' => t('Google font'),
    ),
    '#default_value' => theme_get_setting('block_title_font_type')
  );
  $form ['at']['font']['block_title_font_wrapper']['block_title_font_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="block_title_font_type"]' => array (
          'value' => ''
        )
      )
    )
  );
  $form['at']['font']['block_title_font_wrapper']['block_title_font_container']['block_title_font'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('block_title_font'),
    '#options' => array(
      'btf-sss' => t('Candara, Trebuchet MS, Helvetica Neue, Arial, Helvetica, sans-serif'),
      'btf-ssl' => t('Verdana, Geneva, Arial, Helvetica, sans-serif'),
      'btf-a'   => t('Arial, Helvetica, sans-serif'),
      'btf-cc'  => t('Calibri, Candara, Arial, Helvetica, sans-serif'),
      'btf-m'   => t('Segoe UI, Myriad Pro, Myriad, Arial, Helvetica, sans-serif'),
      'btf-l'   => t('Lucida Sans Unicode, Lucida Sans, Lucida Grande, Verdana, Geneva, sans-serif'),
      'btf-ss'  => t('Garamond, Perpetua, Times New Roman, serif'),
      'btf-sl'  => t('Georgia, Baskerville, Palatino, Palatino Linotype, Book Antiqua, Times New Roman, serif'),
      'btf-ms'  => t('Consolas, Monaco, Courier New, Courier, monospace'),
    ),
  );
  $form ['at']['font']['block_title_font_wrapper']['block_title_font_gwf_container'] = array (
    '#type' => 'container',
    '#states' => array (
      'visible' => array (
        'select[name="block_title_font_type"]' => array (
          'value' => 'gwf'
        )
      )
    )
  );
  $form['at']['font']['block_title_font_wrapper']['block_title_font_gwf_container']['block_title_font_gwf'] = array(
    '#type' => 'select',
    '#title' => t('Font'),
    '#default_value' => theme_get_setting('block_title_font_gwf'),
    '#options' => google_web_fonts_list_options(),
  );
  $form['at']['size'] = array(
    '#type' => 'fieldset',
    '#title' => t('Font Size'),
    '#description' => t('<h3>Font Size</h3>'),
  );
  $form['at']['size']['font_size'] = array(
    '#type' => 'select',
    '#title' => t('Font Size'),
    '#default_value' => theme_get_setting('font_size'),
    '#description' => t('This sets a base font-size on the body element - all text will scale relative to this value.'),
    '#options' => array(
      'fs-smallest' => t('Smallest'),
      'fs-small'    => t('Small'),
      'fs-medium'   => t('Medium'),
      'fs-large'    => t('Large'),
      'fs-largest'  => t('Largest'),
    ),
  );

  // Background Image
  $form['at']['background'] = array(
    '#type' => 'fieldset',
    '#title' => t('Background Image'),
    '#description' => t('<h3>Background Image</h3>'),
  );
  $form['at']['background']['bg_image_path'] = array(
    '#type' => 'textfield',
    '#size' => 60,
    '#titile' => t('Path to custom background image'),
    '#description' => t('The path to the file you would like to use as your background image.'),
    '#value' => theme_get_setting('bg_image_path') ,
  );
  $form['at']['background']['bg_image'] = array(
    '#type' => 'file',
    '#title' => t('Upload background image'),
    '#description' => t('If you don\'t have direct file access to the server, use this field to upload your background image.'),
    '#maxlength' => 40,
  );

  $form['#submit'][] = 'ggp_theme_settings_submit';
  $form['at']['background']['#element_validate'][] = 'ggp_theme_settings_submit';
  return $form;
}
/**
 * Save settings data.
*/
function ggp_theme_settings_submit($form, &$form_state) {
  $settings = array();
  $values = $form_state['values'];


  // Check for a new uploaded file, and use that if available.
  if ($file = file_save_upload('bg_image')) {
    $file->status = FILE_STATUS_PERMANENT;
    if ($image = _ggp_theme_save_image($file)) {
      // Put new image into settings
      $form_state['values']['bg_image_path'] = $image['image_path'];
    }
  }
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
    $setting['image_path'] = file_create_url($destination);

    return $setting;
  }

  return FALSE;
}
