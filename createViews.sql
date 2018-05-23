CREATE VIEW item_count AS
  SELECT DISTINCT h.server_id, h.item_id, i.name, i.value, Sum(h.quantity) AS "count"
  FROM holds h, items i
  WHERE i.value = (SELECT value FROM items WHERE id = item_id)
  AND i.name = (SELECT name FROM items WHERE id = item_id)
  GROUP BY server_id, item_id, i.name, i.value;

	