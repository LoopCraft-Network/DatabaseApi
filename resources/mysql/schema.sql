-- #! mysql

-- #{ playerdata
-- #    { init
CREATE TABLE IF NOT EXISTS PlayerData (
									 Name VARCHAR(32) PRIMARY KEY,
	Kills INT DEFAULT 0,
	Death INT DEFAULT 0,
	Coin INT DEFAULT 0
	);
-- #    }

-- #    { register
-- #        :name string
-- #        :kills int
-- #        :death int
-- #        :coin int
INSERT INTO PlayerData(Name, Kills, Death, Coin) VALUES (:name, :kills, :death, :coin);
-- #    }

-- #    { get
-- #        :name string
SELECT * FROM PlayerData WHERE Name = :name;
-- #    }

-- #    { updateKills
-- #        :name string
-- #        :kills int
UPDATE PlayerData SET Kills = :kills WHERE Name = :name;
-- #    }

-- #    { updateDeaths
-- #        :name string
-- #        :deaths int
UPDATE PlayerData SET Death = :deaths WHERE Name = :name;
-- #    }

-- #    { updateCoins
-- #        :name string
-- #        :coins int
UPDATE PlayerData SET Coin = :coins WHERE Name = :name;
-- #    }
-- #}