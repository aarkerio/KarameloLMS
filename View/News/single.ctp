
<h1>New</h1>

<?
//echo $new->show('News/id/titulo/cuerpo/fecha', $data);
//print_r($data);

?>
<div class="new_title"><?= $data[0]['News']['title'] ?><?= $data[0]['News']['date'] ?></div>

<div class="new_body"><?= $data[0]['News']['body'] ?> <br /><br /><br />

<a href="/news/view/">Regresar</a> <br /></div>

