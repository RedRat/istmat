<?php

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('istmat_autorebuild') && !defined('MAINTENANCE_MODE')) {
  system_rebuild_theme_data();
  drupal_theme_rebuild();
}

function istmat_preprocess_maintenance_page(&$vars) {
//  istmat_preprocess_html($vars);
  istmat_preprocess_page($vars);
}

/*
// When https://drupal.org/node/865536 will be solved, this code may be
// converted to the drupal_add_js() call.
function istmat_preprocess_html(&$vars) {
  if (theme_get_setting('istmat_respondjs')) {
    $respondjs = array(
      '#tag' => 'script',
      '#attributes' => array(
        'type'=> 'text/javascript',
        'src' => file_create_url(drupal_get_path('theme', 'istmat').'/js/respond.min.js'),
      ),
//      '#browsers' => array('IE' => 'lt IE 9', '!IE' => FALSE),
//      '#pre_render' => array('drupal_pre_render_conditional_comments'),
      '#weight' => 999,
      '#value' => '',
      '#prefix' => '<!--[if lte IE 8]>'.PHP_EOL,
      '#suffix' => '<![endif]-->'.PHP_EOL,
    );
    drupal_add_html_head($respondjs, 'respondjs');
  }
}*/

function istmat_preprocess_page(&$vars) {
  $block = module_invoke('search','block_view','search');
  $vars['search_form'] = render($block);

  $vars['header_links'] = ($vars['logged_in']) ? '<a href="'.$vars['base_path'].'user/'.$vars['user']->uid.'">'.t('Profile').'</a> / <a href="'.$vars['base_path'].'user/logout">'.t('Logout').'</a>' : '<a href="'.$vars['base_path'].'user" rel="nofollow">'.t('Login').'</a> / <a href="'.$vars['base_path'].'user/register" rel="nofollow">'.t('Register').'</a>';
  $vars['header_links'] .= '<a class="header-icon" href="mailto://'.variable_get('site_mail', ini_get('sendmail_from')).'" title="Отправить нам письмо"><img src="'.drupal_get_path('theme', 'istmat').'/images/ico_mail.png" /></a>';
  $vars['header_links'] .= '<a class="header-icon" href="#" title="Добавить наш сайт в закладки"><img src="'.drupal_get_path('theme', 'istmat').'/images/ico_star.png" /></a>';
  $vars['header_links'] .= '<a class="header-icon" href="#" title="Посмотреть карту сайта"><img src="'.drupal_get_path('theme', 'istmat').'/images/ico_map.png" /></a>';
  $vars['header_links'] .= '<a class="header-icon" href="#" title="Подписка на ленту новостей"><img src="'.drupal_get_path('theme', 'istmat').'/images/ico_rss.png" /></a>';
//  $vars['header_icons'] = '<a href="mailto://'.variable_get('site_mail', ini_get('sendmail_from')).'" title="Отправить нам письмо"><img src="'.drupal_get_path('theme', 'istmat').'/images/head_mail.png'.'" alt="" /></a>';
//  $vars['header_icons'] .= '<a href="'.$vars['base_path'].'rss.xml" title="Подписка на ленту новостей"><img src="'.drupal_get_path('theme', 'istmat').'/images/head_rss.png'.'" alt="" /></a>';
//  $vars['header_icons'] = '<a href="'.$vars['base_path'].'rss.xml" title="Подписка на ленту новостей"></a><a href="'.$vars['base_path'].'#" title="Добавить сайт в закладки"></a><a href="'.$vars['base_path'].'#" title="Карта сайта"></a><a href="mailto://'.variable_get('site_mail', ini_get('sendmail_from')).'" title="Отправить нам письмо"></a>';
//  $vars['logotype'] = file_create_url(drupal_get_path('theme', 'istmat').'/images/logotype.png');

//  dsm($vars);
  if (theme_get_setting('istmat_respondjs')) {
    drupal_add_js(
      drupal_get_path('theme', 'istmat').'/js/respond.min.js',
      array(
        'group' => JS_LIBRARY,
        'every_page' => TRUE,
        'weight' => -999,
        'preprocess' => FALSE,
      )
    );
  }
}

/*
function istmat_field__field_area($vars) {
  dsm($vars);
}
*/

function istmat_form_alter(&$form, &$form_state, $form_id) {
  // Id's of forms that should be ignored
  $form_ids = array(
    'node_form',
    'system_site_information_settings',
    'user_profile_form',
  );

  // Only wrap in container for certain form
  if (isset($form['#form_id']) && !in_array($form['#form_id'], $form_ids) && !isset($form['#node_edit_form'])) {
    $form['actions']['#theme_wrappers'] = array();
  }

  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#size'] = 35;
    $form['search_block_form']['#attributes']['title'] = t('Введите ключевые слова для поиска');
    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => drupal_get_path('theme', 'istmat').'/images/head_search.png');
    $form['actions']['submit']['#attributes']['title'] = t('Начать поиск!');
/*
    $form['#attributes']['class'][] = 'search-form';
    $form['search_block_form']['#title'] = t('Search'); // Change the text on the label element
    $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
    $form['search_block_form']['#attributes'] = array('placeholder' => t('Search'));
    $form['actions']['submit']['#value'] = t('GO!'); // Change the text on the submit button
    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/searchbutton.png');
*/
  }
//  dsm($form);
}
