<?php
wp_head();

echo do_shortcode('[pdf-embedder url="'. get_field('sample_pdf',$_GET['pdfembed']) .'" width="100px"]');

wp_footer();
?>