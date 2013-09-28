<?php

function istmat_form_system_theme_settings_alter(&$form, $form_state) {
  $form['devel'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Theme development settings'),
  );
  $form['devel']['istmat_autorebuild'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Rebuild theme registry on every page.'),
    '#default_value' => theme_get_setting('istmat_autorebuild'),
    '#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'https://drupal.org/node/173880#theme-registry')),
  );
  $form['devel']['istmat_respondjs'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Add Respond.JS for IE8 and less.'),
    '#default_value' => theme_get_setting('istmat_respondjs'),
    '#description'   => t('This option let you add a <a href="!link">Respond</a> script to support Media-Queries in IE8 and less. WARNING! You MUST enable CSS aggregation for this option to work.', array('!link' => 'https://github.com/scottjehl/Respond')),
    '#disabled'      => !variable_get('preprocess_css', 0),
  );
}
