CREATE TYPE player_career AS ENUM ('Knight', 'Mage', 'Priest');

CREATE TABLE servers (
  id SERIAL,
  running boolean NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE players (
  id SERIAL,
  server_id integer NOT NULL,
  name varchar(11) NOT NULL,
  level smallint NOT NULL,
  health integer NOT NULL,
  career player_career NOT NULL,
  PRIMARY KEY (server_id, id)
);

ALTER TABLE players
  ADD CONSTRAINT fk_player_server
  FOREIGN KEY (server_id)
  REFERENCES servers(id);

CREATE TABLE items (
  id SERIAL,
  name varchar(60) NOT NULL,
  value integer NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE holds (
  server_id integer NOT NULL,
  player_id integer NOT NULL,
  item_id integer NOT NULL,
  quantity integer NOT NULL,
  PRIMARY KEY (server_id, player_id, item_id)
);

ALTER TABLE holds
  ADD CONSTRAINT fk_hold_player
  FOREIGN KEY (server_id, player_id)
  REFERENCES players(server_id, id);

ALTER TABLE holds
  ADD CONSTRAINT fk_hold_item
  FOREIGN KEY (item_id)
  REFERENCES items(id);

CREATE VIEW item_count AS
  SELECT DISTINCT server_id, item_id, Sum(quantity) AS "count"
  FROM holds
  GROUP BY server_id, item_id;

GRANT ALL PRIVILEGES ON TABLE servers TO gamedbuser;
GRANT ALL PRIVILEGES ON TABLE players TO gamedbuser;
GRANT ALL PRIVILEGES ON TABLE items TO gamedbuser;
GRANT ALL PRIVILEGES ON TABLE holds TO gamedbuser;
