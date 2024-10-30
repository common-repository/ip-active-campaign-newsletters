<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//https://help.activecampaign.com/hc/en-us/articles/220709307-Personalization-Tags#h_01HP55MYTZDYVR2T18HP4X3J00

$articles = get_field('articles', $master_post_id);

if (empty($articles)){
setcookie( 'ac_admin_notices', 'No posts selected', time() + 120, COOKIEPATH, COOKIE_DOMAIN );
return;
}

$ad_image = get_field('ad_image', $master_post_id);
$ad_link = get_field('ad_link', $master_post_id);

$exceprt_paragraphs = get_field('exceprt_paragraphs', $master_post_id);
if (empty($exceprt_paragraphs)) $exceprt_paragraphs = 1;

$header_image = get_field('acheader_image', $master_post_id);

$insert_after = get_field('insert_after', $master_post_id);
if (empty($insert_after)) $insert_after = 1;

$trackingcodes = '';
if ($append_tracking) $trackingcodes = 'MailingID=%CAMPAIGNID%&utm_source='. $utm_source . '&utm_medium=' .  $utm_medium . '&utm_content=' .  $utm_content . '&utm_campaign=' .  $utm_campaign;

ob_start();
include('editorial.css');
$css = ob_get_clean();
ob_start();
include('editorialg.css');
$cssg = ob_get_clean();
ob_start(); ?>
<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
   <head>
      <title></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <?php 
      wp_register_style( 'googleapis', 'https://fonts.googleapis.com/css?family=Lato' );
      if (! $preview) { ?>
      <!--[if mso]>
      <xml>
         <o:OfficeDocumentSettings>
            <o:AllowPNG/>
         </o:OfficeDocumentSettings>
      </xml>
      <![endif]--><!--[if !mso]><!-->
      <?php echo wp_kses($cssg, ipacn_allowed_html); ?>
      <!--<![endif]-->
      <?php }
      wp_register_style( 'editorial', 'editorial.css', '', '2' );
    	wp_enqueue_style( 'editorial', 'editorial.css', '', '2');
   	 	wp_add_inline_style( 'editorial', $css );
   	 	echo wp_kses($css, ipacn_allowed_html);
      ?>
   </head>
   <body style="background-color:#fff;margin:0;padding:0;-webkit-text-size-adjust:none;text-size-adjust:none">
      <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;background-color:#fff">
         <tbody>
            <tr>
               <td>
               	<?php if ($header_image) { ?>
                  <table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                     <tbody>
                        <tr>
                           <td>
                              <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" 
                                 style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:730px;margin:0 auto" width="730">
                                 <tbody>
                                    <tr>
                                       <td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;border-bottom:10px solid #9a9a9a;border-top:1px solid #000;vertical-align:top;border-right:0;border-left:0">
                                          <table class="image_block block-1" width="100%" border="0" cellpadding="5" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                             <tr>
                                                <td 
                                                   class="pad">
                                                   <div class="alignment" align="center" style="line-height:10px">
                                                      <div style="max-width:300px"><a href="<?php echo esc_url(sanitize_text_field(get_site_url())); ?>?<?php echo esc_html(sanitize_text_field($trackingcodes)); ?>" target="_blank" style="outline:none" tabindex="-1"><img src="<?php echo esc_url(wp_kses_post($header_image)); ?>" style="display:block;height:auto;border:0;width:100%;max-width: 600px;"></a></div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <?php } ?>
                  <table class="row row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                     <tbody>
                        <tr>
                           <td>
                              <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;border-radius:0;color:#000;width:730px;margin:0 auto" width="730">
                                 <tbody>
                                    <tr>
                                       <td class="column column-1" width="100%" 
                                          style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:20px;padding-left:5px;padding-right:5px;padding-top:20px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                          <table class="text_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                             <tr>
                                                <td class="pad">
                                                   <div style="font-family:sans-serif">
                                                      <div class 
                                                         style="font-size:14px;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.4">
                                                         <p style="margin:0;font-size:14px;mso-line-height-alt:16.8px"><?php echo esc_html(wp_kses_post(gmdate('m/d/Y', strtotime($ac_deployment_date)))); ?></p>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
<?php
if (! empty($articles)){
	$i = 0;
	foreach($articles as $postid){
	 $i++;
	 $post_data = get_post($postid);

	 if (empty($mailing_subject)) {
	 	$mailing_subject = $post_data->post_title;
	 	update_post_meta( $master_post_id, 'mailing_subject', $mailing_subject);
	 }
	 $snippet_image = get_the_post_thumbnail_url($postid);
?>
                  <table class="row row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                     <tbody>
                        <tr>
                           <td>
                              <table 
                                 class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:730px;margin:0 auto" width="730">
                                 <tbody>
                                    <tr>
                                       <td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;border-bottom:1px dotted #333;padding-bottom:20px;padding-top:20px;vertical-align:top;border-top:0;border-right:0;border-left:0">
                                       <?php if ($snippet_image) {
                                       	 ?>
                                          <table class="image_block block-1" 
                                             width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                             <tr>
                                                <td class="pad" style="padding-bottom:20px;width:100%">
                                                   <div class="alignment" align="center" style="line-height:10px">
                                                      <div style="max-width:730px"><a href="<?php echo esc_url(wp_kses_post(get_permalink($post_data->ID))); ?>?<?php echo esc_html(sanitize_text_field($trackingcodes)); ?>" target="_blank" style="outline:none" tabindex="-1"><img src="<?php echo esc_url(wp_kses_post($snippet_image)); ?>" 
                                                         style="display:block;height:auto;border:0;width:100%" width="730" alt="<?php echo esc_html(wp_kses_post(wp_strip_all_tags($post_data->post_title))); ?>" title="<?php echo esc_html(wp_kses_post(wp_strip_all_tags($post_data->post_title))); ?>"></a></div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                          <?php } ?>
                                          <table class="text_block block-2" width="100%" border="0" cellpadding="5" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                             <tr>
                                                <td class="pad">
                                                   <div style="font-family:Tahoma,Verdana,sans-serif">
                                                      <div class 
                                                         style="font-size:34px;font-family:Lato,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#333;line-height:1.4">
                                                         <p style="margin:0 15px 0 15px;font-size:34px;mso-line-height-alt:16.8px"><span style="font-size:34px;"><a href="<?php echo esc_url(wp_kses_post(get_permalink($post_data->ID))); ?>?<?php echo esc_html(sanitize_text_field($trackingcodes)); ?>" target="_blank" style="text-decoration: none; color: #333333;" rel="noopener"><strong><?php echo esc_html(wp_kses_post($post_data->post_title)); ?></strong></a></span></p>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                          <table class="text_block block-3" width="100%" border="0" cellpadding="5" 
                                             cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                             <tr>
                                                <td class="pad">
                                                   <div style="font-family:Tahoma,Verdana,sans-serif">
                                                      <div class style="font-size:16px;font-family:Lato,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#333;line-height:1.4">
                                                         <div style="margin:0 15px 0 15px;font-size:16px;mso-line-height-alt:16.8px">
                                                            <span style="font-size:16px;"><a href="<?php echo esc_url(wp_kses_post(get_permalink($post_data->ID))); ?>?<?php echo esc_html(sanitize_text_field($trackingcodes)); ?>" target="_blank" style="text-decoration: none; color: #333333;" rel="noopener"><?php
$excerpt = '';
if (empty($exceprt_paragraphs)) $exceprt_paragraphs = 1;
if (empty($excerpt)) $excerpt = ipacn_make_excerptp($post_data, $exceprt_paragraphs);
echo wp_kses($excerpt, ipacn_allowed_html); ?></a></span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <?php if ($ad_image && $i == $insert_after){ ?>
                  <table class="row row-7" 
                     align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                     <tbody>
                        <tr>
                           <td>
                              <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:730px;margin:0 auto" width="730">
                                 <tbody>
                                    <tr>
                                       <td class="column column-1" width="100%" 
                                          style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;border-bottom:1px dotted #333;padding-bottom:20px;padding-top:20px;vertical-align:top;border-top:0;border-right:0;border-left:0">
                                          <table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                                             <tr>
                                                <td class="pad" style="width:100%">
                                                   <div class="alignment" align="center" style="line-height:10px">
                                                      <div style="max-width:700px">
                                                         <a href="<?php if (! empty($ad_link['url'])) echo esc_url(wp_kses_post($ad_link['url'])); ?><?php if (stripos($ad_link, '?') !== false){ echo esc_html(sanitize_text_field('&')).esc_html(sanitize_text_field($trackingcodes)); } else { echo esc_html(sanitize_text_field('?')).esc_html(sanitize_text_field($trackingcodes)); } ?>" target="_blank" style="outline:none" tabindex="-1"><img src="<?php echo esc_url(wp_kses_post($ad_image)); ?>" style="display:block;height:auto;border:0;max-width:700px;" ></a>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <?php } ?>
                  
<?php }
} ?>
                  <table class="row row-11" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0">
                     <tbody>
                        <tr>
                           <td>
                              <table 
                                 class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;color:#000;width:730px;margin:0 auto" width="730">
                                 <tbody>
                                    <tr>
                                       <td class="column column-1" width="100%" style="mso-table-lspace:0;mso-table-rspace:0;font-weight:400;text-align:left;padding-bottom:20px;padding-top:20px;vertical-align:top;border-top:0;border-right:0;border-bottom:0;border-left:0">
                                          <table class="text_block block-4" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                             <tr>
                                                <td class="pad">
                                                   <div style="font-family:Tahoma,Verdana,sans-serif">
                                                      <div class style="font-size:14px;font-family:Lato,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.4">
                                                         <p 
                                                            style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="font-size:12px;">Sent to: %EMAIL%</span></p>
                                                            <br style="clear:both" />
                                                            <p 
                                                            style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="font-size:12px;"><a href="%UNSUBSCRIBELINK%" target="_blank">Unsubscribe</a></span></p>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                          <table class="text_block block-5" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" 
                                             style="mso-table-lspace:0;mso-table-rspace:0;word-break:break-word">
                                             <tr>
                                                <td class="pad">
                                                   <div style="font-family:Tahoma,Verdana,sans-serif">
                                                      <div class style="font-size:14px;font-family:Lato,Tahoma,Verdana,Segoe,sans-serif;mso-line-height-alt:16.8px;color:#555;line-height:1.4">
                                                         <p style="margin:0;font-size:14px;text-align:center;mso-line-height-alt:16.8px"><span style="font-size:12px;">%SENDER-INFO-SINGLELINE%</span></p>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <!-- End -->
   </body>
</html>
<?php $email_message = ob_get_clean();