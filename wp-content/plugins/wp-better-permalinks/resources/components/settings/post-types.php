<table class="wbpPage__widgetTable">
  <thead>
    <tr>
      <th>
        <h4><?= __('Post Type', 'wp-better-permalinks'); ?></h4>
      </th>
      <th>
        <h4><?= __('Taxonomy', 'wp-better-permalinks'); ?></h4>
      </th>
    </tr>
  </tbody>
  <thead>
    <?php foreach ($postTypes as $type) : ?>
      <tr>
        <td>
          <label for="wbp-<?= $type['slug']; ?>"
            class="wbpPage__label">
            <?= sprintf('%s (%s)', $type['label'], $type['slug']); ?>
          </label>
        </td>
        <td>
          <select id="wbp-<?= $type['slug']; ?>" name="wbp_<?= $type['slug']; ?>"
            class="wbpPage__select">
            <?php foreach ($type['values'] as $value) : ?>
              <option value="<?= $value['slug']; ?>"
                <?= (isset($config[$type['slug']]) && ($config[$type['slug']] === $value['slug'])) ? 'selected' : ''; ?>>
                <?= $value['slug'] ? sprintf('%s (%s)', $value['label'], $value['slug']) : $value['label']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
    <?php endforeach; ?>
  </thead>
</table>