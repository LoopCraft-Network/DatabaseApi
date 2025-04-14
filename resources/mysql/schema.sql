-- #! mysql

-- #{ udata
-- #    { init
CREATE TABLE IF NOT EXISTS UData (
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
INSERT INTO UData(Name, Kills, Death, Coin) VALUES (:name, :kills, :death, :coin);
-- #    }

-- #    { get
-- #        :name string
SELECT * FROM UData WHERE Name = :name;
-- #    }

-- #    { updateKills
-- #        :name string
-- #        :kills int
UPDATE UData SET Kills = :kills WHERE Name = :name;
-- #    }

-- #    { updateDeaths
-- #        :name string
-- #        :deaths int
UPDATE UData SET Death = :deaths WHERE Name = :name;
-- #    }

-- #    { updateCoins
-- #        :name string
-- #        :coins int
UPDATE UData SET Coin = :coins WHERE Name = :name;
-- #    }
-- #}