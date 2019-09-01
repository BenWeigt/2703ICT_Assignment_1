-- Sqlite only support 5 actual data types (INTEGER, TEXT, BLOB, REAL and NUMERIC). Other common
-- sql types such as VARCHAR, FLOAT and DATE are aliased to these. Consequently the following
-- table definitions use the primitives available rather than the types that would otherwise be 
-- used in a more rich sql engine. See https://www.sqlite.org/draft/datatype3.html for more info.

CREATE TABLE IF NOT EXISTS Posts (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	timestamp INTEGER NOT NULL,
	username TEXT NOT NULL DEFAULT 'Anon',
	title TEXT NOT NULL,
	icon TEXT NOT NULL DEFAULT '💩',
	content NOT NULL
);

CREATE TABLE IF NOT EXISTS Comments (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	post_id INTEGER NOT NULL,
	timestamp INTEGER NOT NULL,
	username TEXT NOT NULL DEFAULT 'Anon',
	content TEXT NOT NULL
);

INSERT INTO Posts VALUES (null, 1568478546, "salty_limes", "Question", "🍆", "What are some declassified government documents that are surprisingly terrifying?");
INSERT INTO Posts VALUES (null, 1565642624, "BarefootUnicorn", "Ocasio-Cortez", "💩", "Ocasio-Cortez mocks straight pride parade: More like a I-Struggle-With-Masculinity parade");
INSERT INTO Posts VALUES (null, 1566173770, "salty_limes", "TIL", "🍆", "TIL that Schizophrenia's hallucinations are shaped by culture. Americans with schizophrenia tend to have more paranoid and harsher voices/hallucinations. In India and Africa people with schizophrenia tend to have more playful and positive voices");
INSERT INTO Posts VALUES (null, 1567096110, "stack-compression", "TIL", "🤏", "TIL because American textbooks are sold at a lower price in Thailand, somebody was reselling them in the US and making enough of a profit to get sued by the publishers, the Supreme Court ultimately ruled against the publishers because the first sale doctrine applies everywhere, not just the US");
INSERT INTO Posts VALUES (null, 1563265994, "ArmoredPancake", "Science", "🐱‍👤", "An indigenous farming technique that’s been around for thousands of years provides the basis for restoring rain forests stripped clear of trees by gold mining and other threats, using biochar, a cheap and effective way to support tree seedling survival during reforestation efforts in the Amazon.");
INSERT INTO Posts VALUES (null, 1563698580, "stack-compression", "Science", "🙏", "People who drank red wine had an increased gut microbiota diversity (a sign of gut health) compared to non-red wine drinkers as well as an association with lower levels of obesity and 'bad' cholesterol (n=916 female twins). This was not observed with white wine, beer or spirits consumption.");
INSERT INTO Posts VALUES (null, 1565060265, "stack-compression", "Science", "😂", "Scientists create method of unprinting paper which can erase black, blue, red and green toners without damaging the paper using pulses of light from a xenon lamp which could help recycle paper at a cheaper cost.");
INSERT INTO Posts VALUES (null, 1566173770, "ArmoredPancake", "Science", "🔥", "Scientists find 27 regions on the genome where epigenetic changes (not changes in DNA, but in it's expression) were correlated with Alzheimers (and were not correlated with age) - suggesting possibility of creating early diagnosis tools in the future");
INSERT INTO Posts VALUES (null, 1564242375, "cmqv", "ProjrammingCJ", "🤘", "[Exceptions are] just going to tell me that it can’t open the configuration file and a stack trace that tells me what line the error happened in and what function call. “ParseConfigFile: configManager.go: 123”. Fuck off.");
INSERT INTO Posts VALUES (null, 1564625173, "stack-compression", "ProjrammingCJ", "😈", "Although LISP and FORTH programs easily generate the shortest programs ever made for most tasks, the brevity they possess comes with a dear price: among the highest MTTR BSOTTA (mean time to repair by someone other than the author), an acronym i recently coined");
INSERT INTO Posts VALUES (null, 1563934201, "ArmoredPancake", "ProjrammingCJ", "👌", "Any experienced C programmer who just reads the Rust book should conclude that Rust >> C.");
INSERT INTO Posts VALUES (null, 1563698580, "salty_limes", "ProjrammingCJ", "😎", "Does WebAssembly or any of its runtimes provide a way to [create C bindings]?");
INSERT INTO Posts VALUES (null, 1557434175, "BarefootUnicorn", "ProjrammingCJ", "👍", "As one of the developers on the Rust project: we consider that kind of over-the-top evangelism counterproductive and unwelcome. [...] I specifically said that I wasn't there to push Rust, just there to explain how I'm working to make Rust an option for more people.");
INSERT INTO Posts VALUES (null, 1563692801, "cmqv", "ProjrammingCJ", "❤️", "Sure we might be needing at least 16GB minimum RAM and have slow loading times in the future once they turned all system apps to Electron but at least they look good, responsive, and actively developed unlike the pile of rubbish we have currently.");

INSERT INTO Comments VALUES (null, 13, 1567371455, "stack-compression", "I always wonder: is brain damage a requirement to do go or is it the other way around?");
INSERT INTO Comments VALUES (null, 0, 1567371455, "salty_limes", "but muh leet systems prestige will get tossed out the window now.");
INSERT INTO Comments VALUES (null, 11, 1567371455, "ArmoredPancake", "Anytime I say something like -yeah, I had to use valgrind and hand calculate 8 way associative cache lookup- my peers will sneer and call me a loser for not doing things the Rust way.");
INSERT INTO Comments VALUES (null, 13, 1567371455, "stack-compression", "Accessibility has its limits. Teaching morality to Gophers is a lost cause, they are beyond salvation.");
INSERT INTO Comments VALUES (null, 13, 1567371455, "cmqv", "JavaScript is the only real language.");
INSERT INTO Comments VALUES (null, 12, 1567371455, "ArmoredPancake", "At this point they are putting more mental effort into justifying these abominations than it would take for them to learn programming languages that aren't JS.");
INSERT INTO Comments VALUES (null, 13, 1567371455, "stack-compression", "Turns out that heat death of the universe won't be caused by its infinite expansion, but by all of Earths dumb tech running on multiple Chrome instances at once.");