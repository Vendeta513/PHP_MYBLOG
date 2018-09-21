<?php if(! empty($article->errors)):?> <!--output error messages when not filled.-->
  <ul>
    <?php foreach($article->errors as $error):?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post" id="formArticle">
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" name="title" placeholder="Article title" id="title" value="<?= htmlspecialchars($article->title); ?>">
  </div>

  <div class="form-group">
    <label for="content">Content:</label>
    <textarea name="content" class="form-control" cols="40" rows="4" placeholder="Article content" id="content"><?= htmlspecialchars($article->content); ?></textarea>
  </div>

  <div class="form-group">
    <label for="published_at">Content Publication date and time:</label>
    <input name="published_at" class="form-control" id="published_at" value="<?= htmlspecialchars($article->published_at); ?>" >
  </div>
  <fieldset>
    <legend>
      Categories
    </legend>
    <?php foreach($categories as $category): ?>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="category[]" value="<?= $category['id']; ?>" id="category<?=$category['id'];?>"
        <?php if(in_array($category['id'], $category_ids)):?>checked<?php endif;?> />
        <label class="form-check-label" for="category<?= $category['id'];?>"><?= htmlspecialchars($category['name']);?></label>
      </div>
    <?php endforeach;?>
  </fieldset>

  <button>Save</button>
</form>
