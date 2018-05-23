CREATE VIEW item_count AS
  SELECT h.server_id, h.item_id, i.name, i.value, Sum(h.quantity) AS "count"
  FROM holds h, items i
	WHERE h.item_id = i.id
	GROUP BY h.server_id, h.item_id, i.name, i.value;
	
GRANT ALL PRIVILEGES ON TABLE item_count TO gamedbuser;