<?php

use ALttP\Randomizer;
use ALttP\Item;

/**
 * These test may have to be updated on any Logic change that adjusts the pooling of the RNG
 */
class RandomizerTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->randomizer = new Randomizer('test_rules');
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->randomizer);
	}

	public function testGetSeedIsNullBeforeRandomization() {
		$this->assertNull($this->randomizer->getSeed());
	}

	public function testGetSeedIsNotNullAfterRandomization() {
		$this->randomizer->makeSeed();

		$this->assertNotNull($this->randomizer->getSeed());
	}

	/**
	 * @group crystals
	 */
	public function testCrystalsNotRandomizedByConfigCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', true);
		Config::set('alttp.test_rules.prize.shuffleCrystals', false);

		$this->randomizer->makeSeed(1337);
		$this->assertEquals([
			Item::get('Crystal1'),
			Item::get('Crystal2'),
			Item::get('Crystal3'),
			Item::get('Crystal4'),
			Item::get('Crystal5'),
			Item::get('Crystal6'),
			Item::get('Crystal7'),
		], [
			$this->randomizer->getWorld()->getLocation("Palace of Darkness - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Swamp Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Skull Woods - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Thieves' Town - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Ice Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Misery Mire - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Turtle Rock - Prize")->getItem(),
		]);
	}

	/**
	 * @group crystals
	 */
	public function testCrystalsNotRandomizedByConfigNoCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', false);
		Config::set('alttp.test_rules.prize.shuffleCrystals', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('Crystal1'),
			Item::get('Crystal2'),
			Item::get('Crystal3'),
			Item::get('Crystal4'),
			Item::get('Crystal5'),
			Item::get('Crystal6'),
			Item::get('Crystal7'),
		], [
			$this->randomizer->getWorld()->getLocation("Palace of Darkness - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Swamp Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Skull Woods - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Thieves' Town - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Ice Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Misery Mire - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Turtle Rock - Prize")->getItem(),
		]);
	}


	/**
	 * @group pendants
	 */
	public function testPendantsNotRandomizedByConfigNoCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', false);
		Config::set('alttp.test_rules.prize.shufflePendants', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('PendantOfCourage'),
			Item::get('PendantOfPower'),
			Item::get('PendantOfWisdom'),
		], [
			$this->randomizer->getWorld()->getLocation("Eastern Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Desert Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Tower of Hera - Prize")->getItem(),
		]);
	}

	/**
	 * @group pendants
	 */
	public function testPendantsNotRandomizedByConfigCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', true);
		Config::set('alttp.test_rules.prize.shufflePendants', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('PendantOfCourage'),
			Item::get('PendantOfPower'),
			Item::get('PendantOfWisdom'),
		], [
			$this->randomizer->getWorld()->getLocation("Eastern Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Desert Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Tower of Hera - Prize")->getItem(),
		]);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedNoMajorGlitches() {
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Sahasrahla's Hut - Left" => "ThreeBombs",
			"Sahasrahla's Hut - Middle" => "BossHeartContainer",
			"Sahasrahla's Hut - Right" => "PieceOfHeart",
			"Sahasrahla" => "BombUpgrade10",
			"King Zora" => "BossHeartContainer",
			"Potion Shop" => "BossHeartContainer",
			"Zora's Ledge" => "ProgressiveSword",
			"Waterfall Fairy - Left" => "FiftyRupees",
			"Waterfall Fairy - Right" => "SilverArrowUpgrade",
			"Master Sword Pedestal" => "ProgressiveArmor",
			"King's Tomb" => "BombUpgrade5",
			"Kakariko Tavern" => "ProgressiveGlove",
			"Chicken House" => "OneRupee",
			"Kakariko Well - Top" => "ThreeHundredRupees",
			"Kakariko Well - Left" => "Hammer",
			"Kakariko Well - Middle" => "ThreeHundredRupees",
			"Kakariko Well - Right" => "TwentyRupees",
			"Kakariko Well - Bottom" => "TwentyRupees",
			"Blind's Hideout - Top" => "BossHeartContainer",
			"Blind's Hideout - Left" => "PieceOfHeart",
			"Blind's Hideout - Right" => "BombUpgrade5",
			"Blind's Hideout - Far Left" => "ThreeHundredRupees",
			"Blind's Hideout - Far Right" => "TwentyRupees",
			"Pegasus Rocks" => "BottleWithGoldBee",
			"Bottle Merchant" => "TwentyRupees",
			"Magic Bat" => "ThreeBombs",
			"Sick Kid" => "TwentyRupees",
			"Lost Woods Hideout" => "BossHeartContainer",
			"Lumberjack Tree" => "TwentyRupees",
			"Graveyard Ledge" => "TwentyRupees",
			"Mushroom" => "ArrowUpgrade5",
			"Floodgate Chest" => "BottleWithBluePotion",
			"Link's House" => "Shovel",
			"Aginah's Cave" => "BombUpgrade5",
			"Mini Moldorm Cave - Far Left" => "ThreeBombs",
			"Mini Moldorm Cave - Left" => "PieceOfHeart",
			"Mini Moldorm Cave - Right" => "PieceOfHeart",
			"Mini Moldorm Cave - Far Right" => "PieceOfHeart",
			"Ice Rod Cave" => "ArrowUpgrade5",
			"Hobo" => "TwentyRupees",
			"Bombos Tablet" => "Boomerang",
			"Cave 45" => "PegasusBoots",
			"Checkerboard Cave" => "PieceOfHeart",
			"Mini Moldorm Cave - NPC" => "ArrowUpgrade10",
			"Library" => "ProgressiveGlove",
			"Maze Race" => "PieceOfHeart",
			"Desert Ledge" => "ProgressiveArmor",
			"Lake Hylia Island" => "TwentyRupees",
			"Sunken Treasure" => "TenArrows",
			"Flute Spot" => "ThreeBombs",
			"Sanctuary" => "TwentyRupees",
			"Sewers - Secret Room - Left" => "PieceOfHeart",
			"Sewers - Secret Room - Middle" => "MapH2",
			"Sewers - Secret Room - Right" => "ThreeBombs",
			"Sewers - Dark Cross" => "MagicMirror",
			"Hyrule Castle - Boomerang Chest" => "KeyH2",
			"Hyrule Castle - Map Chest" => "TenArrows",
			"Hyrule Castle - Zelda's Cell" => "MoonPearl",
			"Link's Uncle" => "TenBombs",
			"Secret Passage" => "TenArrows",
			"Zelda" => "RescueZelda",
			"Eastern Palace - Compass Chest" => "BigKeyP1",
			"Eastern Palace - Big Chest" => "ProgressiveSword",
			"Eastern Palace - Cannonball Chest" => "MapP1",
			"Eastern Palace - Big Key Chest" => "PieceOfHeart",
			"Eastern Palace - Map Chest" => "BossHeartContainer",
			"Eastern Palace - Armos Knights" => "CompassP1",
			"Eastern Palace - Prize" => "Crystal3",
			"Desert Palace - Big Chest" => "KeyP2",
			"Desert Palace - Map Chest" => "MapP2",
			"Desert Palace - Torch" => "BigKeyP2",
			"Desert Palace - Big Key Chest" => "PieceOfHeart",
			"Desert Palace - Compass Chest" => "Bombos",
			"Desert Palace - Lanmolas'" => "CompassP2",
			"Desert Palace - Prize" => "Crystal4",
			"Old Man" => "BombUpgrade5",
			"Spectacle Rock Cave" => "PieceOfHeart",
			"Ether Tablet" => "PieceOfHeart",
			"Spectacle Rock" => "TwentyRupees",
			"Spiral Cave" => "Bottle",
			"Mimic Cave" => "ProgressiveSword",
			"Paradox Cave Lower - Far Left" => "FiftyRupees",
			"Paradox Cave Lower - Left" => "FiftyRupees",
			"Paradox Cave Lower - Right" => "BossHeartContainer",
			"Paradox Cave Lower - Far Right" => "PieceOfHeart",
			"Paradox Cave Lower - Middle" => "BossHeartContainer",
			"Paradox Cave Upper - Left" => "TwentyRupees",
			"Paradox Cave Upper - Right" => "PieceOfHeart",
			"Floating Island" => "TwentyRupees",
			"Tower of Hera - Big Key Chest" => "KeyP3",
			"Tower of Hera - Basement Cage" => "BigKeyP3",
			"Tower of Hera - Map Chest" => "CompassP3",
			"Tower of Hera - Compass Chest" => "BossHeartContainer",
			"Tower of Hera - Big Chest" => "MapP3",
			"Tower of Hera - Moldorm" => "HeartContainer",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "PieceOfHeart",
			"Superbunny Cave - Bottom" => "Lamp",
			"Hookshot Cave - Top Right" => "FireRod",
			"Hookshot Cave - Top Left" => "RedBoomerang",
			"Hookshot Cave - Bottom Left" => "PieceOfHeart",
			"Hookshot Cave - Bottom Right" => "FiveRupees",
			"Spike Cave" => "TwentyRupees",
			"Catfish" => "TwentyRupees",
			"Pyramid" => "TwentyRupees",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "Triforce",
			"Pyramid Fairy - Left" => "BookOfMudora",
			"Pyramid Fairy - Right" => "ThreeHundredRupees",
			"Brewery" => "ThreeBombs",
			"C-Shaped House" => "PieceOfHeart",
			"Chest Game" => "BossHeartContainer",
			"Hammer Pegs" => "CaneOfByrna",
			"Bumper Cave" => "ArrowUpgrade5",
			"Blacksmith" => "TenArrows",
			"Purple Chest" => "ThreeBombs",
			"Hype Cave - Top" => "PieceOfHeart",
			"Hype Cave - Middle Right" => "Hookshot",
			"Hype Cave - Middle Left" => "TwentyRupees",
			"Hype Cave - Bottom" => "ProgressiveSword",
			"Stumpy" => "OcarinaInactive",
			"Hype Cave - NPC" => "TwentyRupees",
			"Digging Game" => "FiveRupees",
			"Mire Shed - Left" => "BombUpgrade5",
			"Mire Shed - Right" => "ArrowUpgrade5",
			"Palace of Darkness - Shooter Room" => "ThreeHundredRupees",
			"Palace of Darkness - Big Key Chest" => "BottleWithRedPotion",
			"Palace of Darkness - The Arena - Ledge" => "KeyD1",
			"Palace of Darkness - The Arena - Bridge" => "KeyD1",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "KeyD1",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "BigKeyD1",
			"Palace of Darkness - Dark Basement - Left" => "KeyD1",
			"Palace of Darkness - Dark Basement - Right" => "CompassD1",
			"Palace of Darkness - Dark Maze - Top" => "TwentyRupees",
			"Palace of Darkness - Dark Maze - Bottom" => "Quake",
			"Palace of Darkness - Helmasaur King" => "ArrowUpgrade5",
			"Palace of Darkness - Prize" => "Crystal5",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "CompassD2",
			"Swamp Palace - Big Key Chest" => "ProgressiveShield",
			"Swamp Palace - Map Chest" => "BigKeyD2",
			"Swamp Palace - West Chest" => "PieceOfHeart",
			"Swamp Palace - Compass Chest" => "TenArrows",
			"Swamp Palace - Flooded Room - Left" => "FiveRupees",
			"Swamp Palace - Flooded Room - Right" => "OneHundredRupees",
			"Swamp Palace - Waterfall Room" => "MapD2",
			"Swamp Palace - Arrghus" => "PieceOfHeart",
			"Swamp Palace - Prize" => "PendantOfWisdom",
			"Skull Woods - Big Chest" => "KeyD3",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "CompassD3",
			"Skull Woods - Map Chest" => "TwentyRupees",
			"Skull Woods - Bridge Room" => "BigKeyD3",
			"Skull Woods - Pot Prison" => "MapD3",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "ProgressiveShield",
			"Skull Woods - Prize" => "PendantOfCourage",
			"Thieves' Town - Attic" => "OneRupee",
			"Thieves' Town - Big Key Chest" => "Flippers",
			"Thieves' Town - Map Chest" => "CompassD4",
			"Thieves' Town - Compass Chest" => "BigKeyD4",
			"Thieves' Town - Ambush Chest" => "FiftyRupees",
			"Thieves' Town - Big Chest" => "KeyD4",
			"Thieves' Town - Blind's Cell" => "BombUpgrade5",
			"Thieves' Town - Blind" => "MapD4",
			"Thieves' Town - Prize" => "PendantOfPower",
			"Ice Palace - Big Key Chest" => "KeyD5",
			"Ice Palace - Compass Chest" => "PieceOfHeart",
			"Ice Palace - Map Chest" => "BigKeyD5",
			"Ice Palace - Spike Room" => "HalfMagic",
			"Ice Palace - Freezor Chest" => "MapD5",
			"Ice Palace - Iced T Room" => "IceRod",
			"Ice Palace - Big Chest" => "CompassD5",
			"Ice Palace - Kholdstare" => "KeyD5",
			"Ice Palace - Prize" => "Crystal1",
			"Misery Mire - Big Chest" => "MapD6",
			"Misery Mire - Main Lobby" => "CaneOfSomaria",
			"Misery Mire - Big Key Chest" => "BigKeyD6",
			"Misery Mire - Compass Chest" => "KeyD6",
			"Misery Mire - Bridge Chest" => "KeyD6",
			"Misery Mire - Map Chest" => "TwentyRupees",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "CompassD6",
			"Misery Mire - Prize" => "Crystal7",
			"Turtle Rock - Chain Chomps" => "KeyD7",
			"Turtle Rock - Compass Chest" => "CompassD7",
			"Turtle Rock - Roller Room - Left" => "BigKeyD7",
			"Turtle Rock - Roller Room - Right" => "KeyD7",
			"Turtle Rock - Big Chest" => "KeyD7",
			"Turtle Rock - Big Key Chest" => "TwentyRupees",
			"Turtle Rock - Crystaroller Room" => "ArrowUpgrade5",
			"Turtle Rock - Eye Bridge - Bottom Left" => "KeyD7",
			"Turtle Rock - Eye Bridge - Bottom Right" => "TwentyRupees",
			"Turtle Rock - Eye Bridge - Top Left" => "MapD7",
			"Turtle Rock - Eye Bridge - Top Right" => "Mushroom",
			"Turtle Rock - Trinexx" => "Bow",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "ThreeBombs",
			"Ganon's Tower - DMs Room - Top Left" => "Arrow",
			"Ganon's Tower - DMs Room - Top Right" => "Cape",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "Powder",
			"Ganon's Tower - Randomizer Room - Top Left" => "TwentyRupees",
			"Ganon's Tower - Randomizer Room - Top Right" => "ProgressiveShield",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "FiveRupees",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "MapA2",
			"Ganon's Tower - Firesnake Room" => "TwentyRupees",
			"Ganon's Tower - Map Chest" => "PieceOfHeart",
			"Ganon's Tower - Big Chest" => "CompassA2",
			"Ganon's Tower - Hope Room - Left" => "KeyA2",
			"Ganon's Tower - Hope Room - Right" => "KeyA2",
			"Ganon's Tower - Bob's Chest" => "ThreeBombs",
			"Ganon's Tower - Tile Room" => "BigKeyA2",
			"Ganon's Tower - Compass Room - Top Left" => "FiftyRupees",
			"Ganon's Tower - Compass Room - Top Right" => "PieceOfHeart",
			"Ganon's Tower - Compass Room - Bottom Left" => "TwentyRupees",
			"Ganon's Tower - Compass Room - Bottom Right" => "FiftyRupees",
			"Ganon's Tower - Big Key Chest" => "TwentyRupees",
			"Ganon's Tower - Big Key Room - Left" => "KeyA2",
			"Ganon's Tower - Big Key Room - Right" => "BugCatchingNet",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "PieceOfHeart",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "Ether",
			"Ganon's Tower - Pre-Moldorm Chest" => "FiftyRupees",
			"Ganon's Tower - Moldorm Chest" => "TwentyRupees",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Bombos",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBee",
			"Pyramid Bottle" => "BottleWithRedPotion",
		], $loc_item_array);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedOverworldGlitches() {
		$this->randomizer = new Randomizer('test_rules', 'OverworldGlitches');
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Sahasrahla's Hut - Left" => "TwentyRupees",
			"Sahasrahla's Hut - Middle" => "Mushroom",
			"Sahasrahla's Hut - Right" => "TenArrows",
			"Sahasrahla" => "FiftyRupees",
			"King Zora" => "FiveRupees",
			"Potion Shop" => "BossHeartContainer",
			"Zora's Ledge" => "ProgressiveArmor",
			"Waterfall Fairy - Left" => "FiftyRupees",
			"Waterfall Fairy - Right" => "BombUpgrade5",
			"Master Sword Pedestal" => "ThreeHundredRupees",
			"King's Tomb" => "OneRupee",
			"Kakariko Tavern" => "ProgressiveShield",
			"Chicken House" => "PieceOfHeart",
			"Kakariko Well - Top" => "BossHeartContainer",
			"Kakariko Well - Left" => "RedBoomerang",
			"Kakariko Well - Middle" => "PieceOfHeart",
			"Kakariko Well - Right" => "TwentyRupees",
			"Kakariko Well - Bottom" => "PieceOfHeart",
			"Blind's Hideout - Top" => "OneHundredRupees",
			"Blind's Hideout - Left" => "ProgressiveSword",
			"Blind's Hideout - Right" => "BossHeartContainer",
			"Blind's Hideout - Far Left" => "TwentyRupees",
			"Blind's Hideout - Far Right" => "PieceOfHeart",
			"Pegasus Rocks" => "PieceOfHeart",
			"Bottle Merchant" => "PieceOfHeart",
			"Magic Bat" => "PieceOfHeart",
			"Sick Kid" => "TenArrows",
			"Lost Woods Hideout" => "BombUpgrade5",
			"Lumberjack Tree" => "TwentyRupees",
			"Graveyard Ledge" => "Cape",
			"Mushroom" => "BossHeartContainer",
			"Floodgate Chest" => "FiveRupees",
			"Link's House" => "TwentyRupees",
			"Aginah's Cave" => "TwentyRupees",
			"Mini Moldorm Cave - Far Left" => "MagicMirror",
			"Mini Moldorm Cave - Left" => "ProgressiveSword",
			"Mini Moldorm Cave - Right" => "FiveRupees",
			"Mini Moldorm Cave - Far Right" => "PieceOfHeart",
			"Ice Rod Cave" => "BombUpgrade5",
			"Hobo" => "BossHeartContainer",
			"Bombos Tablet" => "FiftyRupees",
			"Cave 45" => "ArrowUpgrade5",
			"Checkerboard Cave" => "ProgressiveArmor",
			"Mini Moldorm Cave - NPC" => "TwentyRupees",
			"Library" => "TenArrows",
			"Maze Race" => "TenArrows",
			"Desert Ledge" => "Ether",
			"Lake Hylia Island" => "HalfMagic",
			"Sunken Treasure" => "PieceOfHeart",
			"Flute Spot" => "BombUpgrade5",
			"Sanctuary" => "ThreeBombs",
			"Sewers - Secret Room - Left" => "ArrowUpgrade10",
			"Sewers - Secret Room - Middle" => "TenArrows",
			"Sewers - Secret Room - Right" => "Hammer",
			"Sewers - Dark Cross" => "PieceOfHeart",
			"Hyrule Castle - Boomerang Chest" => "PieceOfHeart",
			"Hyrule Castle - Map Chest" => "KeyH2",
			"Hyrule Castle - Zelda's Cell" => "MapH2",
			"Link's Uncle" => "CaneOfSomaria",
			"Secret Passage" => "PieceOfHeart",
			"Zelda" => "RescueZelda",
			"Eastern Palace - Compass Chest" => "Hookshot",
			"Eastern Palace - Big Chest" => "MapP1",
			"Eastern Palace - Cannonball Chest" => "Flippers",
			"Eastern Palace - Big Key Chest" => "CompassP1",
			"Eastern Palace - Map Chest" => "BigKeyP1",
			"Eastern Palace - Armos Knights" => "ProgressiveSword",
			"Eastern Palace - Prize" => "Crystal3",
			"Desert Palace - Big Chest" => "TwentyRupees",
			"Desert Palace - Map Chest" => "BigKeyP2",
			"Desert Palace - Torch" => "KeyP2",
			"Desert Palace - Big Key Chest" => "PieceOfHeart",
			"Desert Palace - Compass Chest" => "CompassP2",
			"Desert Palace - Lanmolas'" => "MapP2",
			"Desert Palace - Prize" => "Crystal4",
			"Old Man" => "BombUpgrade5",
			"Spectacle Rock Cave" => "Lamp",
			"Ether Tablet" => "ArrowUpgrade5",
			"Spectacle Rock" => "PieceOfHeart",
			"Spiral Cave" => "ThreeBombs",
			"Mimic Cave" => "BossHeartContainer",
			"Paradox Cave Lower - Far Left" => "BombUpgrade5",
			"Paradox Cave Lower - Left" => "TwentyRupees",
			"Paradox Cave Lower - Right" => "ArrowUpgrade5",
			"Paradox Cave Lower - Far Right" => "Bow",
			"Paradox Cave Lower - Middle" => "ThreeBombs",
			"Paradox Cave Upper - Left" => "ThreeBombs",
			"Paradox Cave Upper - Right" => "ThreeHundredRupees",
			"Floating Island" => "ThreeBombs",
			"Tower of Hera - Big Key Chest" => "MapP3",
			"Tower of Hera - Basement Cage" => "BigKeyP3",
			"Tower of Hera - Map Chest" => "CompassP3",
			"Tower of Hera - Compass Chest" => "TwentyRupees",
			"Tower of Hera - Big Chest" => "FireRod",
			"Tower of Hera - Moldorm" => "KeyP3",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "BugCatchingNet",
			"Superbunny Cave - Bottom" => "ThreeBombs",
			"Hookshot Cave - Top Right" => "BossHeartContainer",
			"Hookshot Cave - Top Left" => "BossHeartContainer",
			"Hookshot Cave - Bottom Left" => "TwentyRupees",
			"Hookshot Cave - Bottom Right" => "TwentyRupees",
			"Spike Cave" => "PieceOfHeart",
			"Catfish" => "PieceOfHeart",
			"Pyramid" => "BossHeartContainer",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "Triforce",
			"Pyramid Fairy - Left" => "TwentyRupees",
			"Pyramid Fairy - Right" => "TwentyRupees",
			"Brewery" => "PieceOfHeart",
			"C-Shaped House" => "Bottle",
			"Chest Game" => "FiftyRupees",
			"Hammer Pegs" => "ThreeBombs",
			"Bumper Cave" => "OneRupee",
			"Blacksmith" => "ProgressiveShield",
			"Purple Chest" => "TwentyRupees",
			"Hype Cave - Top" => "ThreeHundredRupees",
			"Hype Cave - Middle Right" => "PieceOfHeart",
			"Hype Cave - Middle Left" => "TwentyRupees",
			"Hype Cave - Bottom" => "PieceOfHeart",
			"Stumpy" => "Quake",
			"Hype Cave - NPC" => "BookOfMudora",
			"Digging Game" => "ArrowUpgrade5",
			"Mire Shed - Left" => "TwentyRupees",
			"Mire Shed - Right" => "PieceOfHeart",
			"Palace of Darkness - Shooter Room" => "KeyD1",
			"Palace of Darkness - Big Key Chest" => "KeyD1",
			"Palace of Darkness - The Arena - Ledge" => "CaneOfByrna",
			"Palace of Darkness - The Arena - Bridge" => "KeyD1",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "FiftyRupees",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "FiveRupees",
			"Palace of Darkness - Dark Basement - Left" => "BigKeyD1",
			"Palace of Darkness - Dark Basement - Right" => "KeyD1",
			"Palace of Darkness - Dark Maze - Top" => "Boomerang",
			"Palace of Darkness - Dark Maze - Bottom" => "CompassD1",
			"Palace of Darkness - Helmasaur King" => "BottleWithGoldBee",
			"Palace of Darkness - Prize" => "Crystal5",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "ArrowUpgrade5",
			"Swamp Palace - Big Key Chest" => "CompassD2",
			"Swamp Palace - Map Chest" => "OcarinaInactive",
			"Swamp Palace - West Chest" => "TwentyRupees",
			"Swamp Palace - Compass Chest" => "ThreeBombs",
			"Swamp Palace - Flooded Room - Left" => "ThreeHundredRupees",
			"Swamp Palace - Flooded Room - Right" => "TwentyRupees",
			"Swamp Palace - Waterfall Room" => "BigKeyD2",
			"Swamp Palace - Arrghus" => "MapD2",
			"Swamp Palace - Prize" => "PendantOfWisdom",
			"Skull Woods - Big Chest" => "BigKeyD3",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "PieceOfHeart",
			"Skull Woods - Map Chest" => "KeyD3",
			"Skull Woods - Bridge Room" => "MapD3",
			"Skull Woods - Pot Prison" => "MoonPearl",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "CompassD3",
			"Skull Woods - Prize" => "PendantOfCourage",
			"Thieves' Town - Attic" => "MapD4",
			"Thieves' Town - Big Key Chest" => "Shovel",
			"Thieves' Town - Map Chest" => "BottleWithRedPotion",
			"Thieves' Town - Compass Chest" => "TwentyRupees",
			"Thieves' Town - Ambush Chest" => "BigKeyD4",
			"Thieves' Town - Big Chest" => "KeyD4",
			"Thieves' Town - Blind's Cell" => "CompassD4",
			"Thieves' Town - Blind" => "TwentyRupees",
			"Thieves' Town - Prize" => "PendantOfPower",
			"Ice Palace - Big Key Chest" => "MapD5",
			"Ice Palace - Compass Chest" => "ThreeBombs",
			"Ice Palace - Map Chest" => "ProgressiveShield",
			"Ice Palace - Spike Room" => "TwentyRupees",
			"Ice Palace - Freezor Chest" => "BigKeyD5",
			"Ice Palace - Iced T Room" => "CompassD5",
			"Ice Palace - Big Chest" => "KeyD5",
			"Ice Palace - Kholdstare" => "KeyD5",
			"Ice Palace - Prize" => "Crystal1",
			"Misery Mire - Big Chest" => "KeyD6",
			"Misery Mire - Main Lobby" => "BossHeartContainer",
			"Misery Mire - Big Key Chest" => "MapD6",
			"Misery Mire - Compass Chest" => "CompassD6",
			"Misery Mire - Bridge Chest" => "KeyD6",
			"Misery Mire - Map Chest" => "BigKeyD6",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "HeartContainer",
			"Misery Mire - Prize" => "Crystal7",
			"Turtle Rock - Chain Chomps" => "BigKeyD7",
			"Turtle Rock - Compass Chest" => "KeyD7",
			"Turtle Rock - Roller Room - Left" => "CompassD7",
			"Turtle Rock - Roller Room - Right" => "TenBombs",
			"Turtle Rock - Big Chest" => "KeyD7",
			"Turtle Rock - Big Key Chest" => "KeyD7",
			"Turtle Rock - Crystaroller Room" => "MapD7",
			"Turtle Rock - Eye Bridge - Bottom Left" => "TwentyRupees",
			"Turtle Rock - Eye Bridge - Bottom Right" => "PieceOfHeart",
			"Turtle Rock - Eye Bridge - Top Left" => "TwentyRupees",
			"Turtle Rock - Eye Bridge - Top Right" => "KeyD7",
			"Turtle Rock - Trinexx" => "ArrowUpgrade5",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "TwentyRupees",
			"Ganon's Tower - DMs Room - Top Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Top Right" => "FiftyRupees",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "ProgressiveSword",
			"Ganon's Tower - Randomizer Room - Top Left" => "MapA2",
			"Ganon's Tower - Randomizer Room - Top Right" => "TwentyRupees",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "BottleWithBluePotion",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "SilverArrowUpgrade",
			"Ganon's Tower - Firesnake Room" => "Bombos",
			"Ganon's Tower - Map Chest" => "Powder",
			"Ganon's Tower - Big Chest" => "ProgressiveGlove",
			"Ganon's Tower - Hope Room - Left" => "KeyA2",
			"Ganon's Tower - Hope Room - Right" => "Arrow",
			"Ganon's Tower - Bob's Chest" => "KeyA2",
			"Ganon's Tower - Tile Room" => "IceRod",
			"Ganon's Tower - Compass Room - Top Left" => "ProgressiveGlove",
			"Ganon's Tower - Compass Room - Top Right" => "PieceOfHeart",
			"Ganon's Tower - Compass Room - Bottom Left" => "TwentyRupees",
			"Ganon's Tower - Compass Room - Bottom Right" => "BigKeyA2",
			"Ganon's Tower - Big Key Chest" => "TwentyRupees",
			"Ganon's Tower - Big Key Room - Left" => "CompassA2",
			"Ganon's Tower - Big Key Room - Right" => "TwentyRupees",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "ThreeHundredRupees",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "PieceOfHeart",
			"Ganon's Tower - Pre-Moldorm Chest" => "BombUpgrade10",
			"Ganon's Tower - Moldorm Chest" => "FiftyRupees",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Bombos",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBee",
			"Pyramid Bottle" => "BottleWithRedPotion",
		], $loc_item_array);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedMajorGlitches() {
		$this->randomizer = new Randomizer('test_rules', 'MajorGlitches');
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Sahasrahla's Hut - Left" => "BossHeartContainer",
			"Sahasrahla's Hut - Middle" => "Mushroom",
			"Sahasrahla's Hut - Right" => "TenArrows",
			"Sahasrahla" => "FiftyRupees",
			"King Zora" => "FiveRupees",
			"Potion Shop" => "BossHeartContainer",
			"Zora's Ledge" => "ProgressiveArmor",
			"Waterfall Fairy - Left" => "FiftyRupees",
			"Waterfall Fairy - Right" => "BombUpgrade5",
			"Master Sword Pedestal" => "OneRupee",
			"King's Tomb" => "PieceOfHeart",
			"Kakariko Tavern" => "ProgressiveShield",
			"Chicken House" => "TwentyRupees",
			"Kakariko Well - Top" => "BossHeartContainer",
			"Kakariko Well - Left" => "RedBoomerang",
			"Kakariko Well - Middle" => "PieceOfHeart",
			"Kakariko Well - Right" => "ArrowUpgrade5",
			"Kakariko Well - Bottom" => "PieceOfHeart",
			"Blind's Hideout - Top" => "OneHundredRupees",
			"Blind's Hideout - Left" => "ProgressiveSword",
			"Blind's Hideout - Right" => "BossHeartContainer",
			"Blind's Hideout - Far Left" => "TwentyRupees",
			"Blind's Hideout - Far Right" => "PieceOfHeart",
			"Pegasus Rocks" => "ThreeHundredRupees",
			"Bottle Merchant" => "PieceOfHeart",
			"Magic Bat" => "PieceOfHeart",
			"Sick Kid" => "OneRupee",
			"Lost Woods Hideout" => "BombUpgrade5",
			"Lumberjack Tree" => "TwentyRupees",
			"Graveyard Ledge" => "Cape",
			"Mushroom" => "BombUpgrade10",
			"Floodgate Chest" => "BossHeartContainer",
			"Link's House" => "TwentyRupees",
			"Aginah's Cave" => "TwentyRupees",
			"Mini Moldorm Cave - Far Left" => "Quake",
			"Mini Moldorm Cave - Left" => "TwentyRupees",
			"Mini Moldorm Cave - Right" => "FiveRupees",
			"Mini Moldorm Cave - Far Right" => "PieceOfHeart",
			"Ice Rod Cave" => "BombUpgrade5",
			"Hobo" => "BossHeartContainer",
			"Bombos Tablet" => "FiftyRupees",
			"Cave 45" => "ArrowUpgrade5",
			"Checkerboard Cave" => "ProgressiveArmor",
			"Mini Moldorm Cave - NPC" => "TwentyRupees",
			"Library" => "TenArrows",
			"Maze Race" => "SilverArrowUpgrade",
			"Desert Ledge" => "Ether",
			"Lake Hylia Island" => "HalfMagic",
			"Sunken Treasure" => "PieceOfHeart",
			"Flute Spot" => "TwentyRupees",
			"Sanctuary" => "ThreeBombs",
			"Sewers - Secret Room - Left" => "ArrowUpgrade10",
			"Sewers - Secret Room - Middle" => "TenArrows",
			"Sewers - Secret Room - Right" => "Hammer",
			"Sewers - Dark Cross" => "PieceOfHeart",
			"Hyrule Castle - Boomerang Chest" => "PieceOfHeart",
			"Hyrule Castle - Map Chest" => "KeyH2",
			"Hyrule Castle - Zelda's Cell" => "MapH2",
			"Link's Uncle" => "CaneOfSomaria",
			"Secret Passage" => "PieceOfHeart",
			"Zelda" => "RescueZelda",
			"Eastern Palace - Compass Chest" => "Hookshot",
			"Eastern Palace - Big Chest" => "MapP1",
			"Eastern Palace - Cannonball Chest" => "Flippers",
			"Eastern Palace - Big Key Chest" => "CompassP1",
			"Eastern Palace - Map Chest" => "BigKeyP1",
			"Eastern Palace - Armos Knights" => "ProgressiveSword",
			"Eastern Palace - Prize" => "Crystal3",
			"Desert Palace - Big Chest" => "Bottle",
			"Desert Palace - Map Chest" => "BigKeyP2",
			"Desert Palace - Torch" => "KeyP2",
			"Desert Palace - Big Key Chest" => "PieceOfHeart",
			"Desert Palace - Compass Chest" => "CompassP2",
			"Desert Palace - Lanmolas'" => "MapP2",
			"Desert Palace - Prize" => "Crystal4",
			"Old Man" => "BombUpgrade5",
			"Spectacle Rock Cave" => "Lamp",
			"Ether Tablet" => "ArrowUpgrade5",
			"Spectacle Rock" => "BossHeartContainer",
			"Spiral Cave" => "ThreeBombs",
			"Mimic Cave" => "BossHeartContainer",
			"Paradox Cave Lower - Far Left" => "BombUpgrade5",
			"Paradox Cave Lower - Left" => "TwentyRupees",
			"Paradox Cave Lower - Right" => "ArrowUpgrade5",
			"Paradox Cave Lower - Far Right" => "Bow",
			"Paradox Cave Lower - Middle" => "FiftyRupees",
			"Paradox Cave Upper - Left" => "PieceOfHeart",
			"Paradox Cave Upper - Right" => "ThreeHundredRupees",
			"Floating Island" => "ThreeBombs",
			"Tower of Hera - Big Key Chest" => "MapP3",
			"Tower of Hera - Basement Cage" => "Arrow",
			"Tower of Hera - Map Chest" => "CompassP3",
			"Tower of Hera - Compass Chest" => "KeyP3",
			"Tower of Hera - Big Chest" => "FireRod",
			"Tower of Hera - Moldorm" => "BigKeyP3",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "BugCatchingNet",
			"Superbunny Cave - Bottom" => "ThreeBombs",
			"Hookshot Cave - Top Right" => "ThreeBombs",
			"Hookshot Cave - Top Left" => "TenArrows",
			"Hookshot Cave - Bottom Left" => "TwentyRupees",
			"Hookshot Cave - Bottom Right" => "TwentyRupees",
			"Spike Cave" => "PieceOfHeart",
			"Catfish" => "PieceOfHeart",
			"Pyramid" => "BossHeartContainer",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "Triforce",
			"Pyramid Fairy - Left" => "TwentyRupees",
			"Pyramid Fairy - Right" => "TwentyRupees",
			"Brewery" => "PieceOfHeart",
			"C-Shaped House" => "ThreeBombs",
			"Chest Game" => "FiftyRupees",
			"Hammer Pegs" => "ThreeBombs",
			"Bumper Cave" => "TwentyRupees",
			"Blacksmith" => "ProgressiveShield",
			"Purple Chest" => "TwentyRupees",
			"Hype Cave - Top" => "ThreeHundredRupees",
			"Hype Cave - Middle Right" => "PieceOfHeart",
			"Hype Cave - Middle Left" => "PieceOfHeart",
			"Hype Cave - Bottom" => "PieceOfHeart",
			"Stumpy" => "Shovel",
			"Hype Cave - NPC" => "BookOfMudora",
			"Digging Game" => "ArrowUpgrade5",
			"Mire Shed - Left" => "PieceOfHeart",
			"Mire Shed - Right" => "PieceOfHeart",
			"Palace of Darkness - Shooter Room" => "KeyD1",
			"Palace of Darkness - Big Key Chest" => "KeyD1",
			"Palace of Darkness - The Arena - Ledge" => "CaneOfByrna",
			"Palace of Darkness - The Arena - Bridge" => "KeyD1",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "TenArrows",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "FiveRupees",
			"Palace of Darkness - Dark Basement - Left" => "BigKeyD1",
			"Palace of Darkness - Dark Basement - Right" => "KeyD1",
			"Palace of Darkness - Dark Maze - Top" => "Boomerang",
			"Palace of Darkness - Dark Maze - Bottom" => "CompassD1",
			"Palace of Darkness - Helmasaur King" => "BottleWithGoldBee",
			"Palace of Darkness - Prize" => "Crystal5",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "TwentyRupees",
			"Swamp Palace - Big Key Chest" => "CompassD2",
			"Swamp Palace - Map Chest" => "OcarinaInactive",
			"Swamp Palace - West Chest" => "TwentyRupees",
			"Swamp Palace - Compass Chest" => "ThreeBombs",
			"Swamp Palace - Flooded Room - Left" => "ThreeHundredRupees",
			"Swamp Palace - Flooded Room - Right" => "TwentyRupees",
			"Swamp Palace - Waterfall Room" => "BigKeyD2",
			"Swamp Palace - Arrghus" => "MapD2",
			"Swamp Palace - Prize" => "PendantOfWisdom",
			"Skull Woods - Big Chest" => "BigKeyD3",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "TwentyRupees",
			"Skull Woods - Map Chest" => "KeyD3",
			"Skull Woods - Bridge Room" => "MapD3",
			"Skull Woods - Pot Prison" => "BottleWithRedPotion",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "CompassD3",
			"Skull Woods - Prize" => "PendantOfCourage",
			"Thieves' Town - Attic" => "MapD4",
			"Thieves' Town - Big Key Chest" => "IceRod",
			"Thieves' Town - Map Chest" => "Bombos",
			"Thieves' Town - Compass Chest" => "TwentyRupees",
			"Thieves' Town - Ambush Chest" => "BigKeyD4",
			"Thieves' Town - Big Chest" => "KeyD4",
			"Thieves' Town - Blind's Cell" => "CompassD4",
			"Thieves' Town - Blind" => "TwentyRupees",
			"Thieves' Town - Prize" => "PendantOfPower",
			"Ice Palace - Big Key Chest" => "MapD5",
			"Ice Palace - Compass Chest" => "ThreeBombs",
			"Ice Palace - Map Chest" => "ProgressiveShield",
			"Ice Palace - Spike Room" => "TwentyRupees",
			"Ice Palace - Freezor Chest" => "BigKeyD5",
			"Ice Palace - Iced T Room" => "CompassD5",
			"Ice Palace - Big Chest" => "KeyD5",
			"Ice Palace - Kholdstare" => "KeyD5",
			"Ice Palace - Prize" => "Crystal1",
			"Misery Mire - Big Chest" => "KeyD6",
			"Misery Mire - Main Lobby" => "BossHeartContainer",
			"Misery Mire - Big Key Chest" => "MapD6",
			"Misery Mire - Compass Chest" => "CompassD6",
			"Misery Mire - Bridge Chest" => "KeyD6",
			"Misery Mire - Map Chest" => "BigKeyD6",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "HeartContainer",
			"Misery Mire - Prize" => "Crystal7",
			"Turtle Rock - Chain Chomps" => "KeyD7",
			"Turtle Rock - Compass Chest" => "KeyD7",
			"Turtle Rock - Roller Room - Left" => "CompassD7",
			"Turtle Rock - Roller Room - Right" => "TenBombs",
			"Turtle Rock - Big Chest" => "TwentyRupees",
			"Turtle Rock - Big Key Chest" => "KeyD7",
			"Turtle Rock - Crystaroller Room" => "MapD7",
			"Turtle Rock - Eye Bridge - Bottom Left" => "TwentyRupees",
			"Turtle Rock - Eye Bridge - Bottom Right" => "KeyD7",
			"Turtle Rock - Eye Bridge - Top Left" => "FiveRupees",
			"Turtle Rock - Eye Bridge - Top Right" => "BigKeyD7",
			"Turtle Rock - Trinexx" => "ArrowUpgrade5",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "TwentyRupees",
			"Ganon's Tower - DMs Room - Top Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Top Right" => "FiftyRupees",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "ProgressiveSword",
			"Ganon's Tower - Randomizer Room - Top Left" => "MapA2",
			"Ganon's Tower - Randomizer Room - Top Right" => "TwentyRupees",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "BottleWithBluePotion",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "PieceOfHeart",
			"Ganon's Tower - Firesnake Room" => "MoonPearl",
			"Ganon's Tower - Map Chest" => "Powder",
			"Ganon's Tower - Big Chest" => "ProgressiveGlove",
			"Ganon's Tower - Hope Room - Left" => "KeyA2",
			"Ganon's Tower - Hope Room - Right" => "BombUpgrade5",
			"Ganon's Tower - Bob's Chest" => "KeyA2",
			"Ganon's Tower - Tile Room" => "MagicMirror",
			"Ganon's Tower - Compass Room - Top Left" => "ProgressiveGlove",
			"Ganon's Tower - Compass Room - Top Right" => "PieceOfHeart",
			"Ganon's Tower - Compass Room - Bottom Left" => "TwentyRupees",
			"Ganon's Tower - Compass Room - Bottom Right" => "BigKeyA2",
			"Ganon's Tower - Big Key Chest" => "TwentyRupees",
			"Ganon's Tower - Big Key Room - Left" => "CompassA2",
			"Ganon's Tower - Big Key Room - Right" => "TwentyRupees",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "ThreeHundredRupees",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "PieceOfHeart",
			"Ganon's Tower - Pre-Moldorm Chest" => "ProgressiveSword",
			"Ganon's Tower - Moldorm Chest" => "FiftyRupees",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Bombos",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBee",
			"Pyramid Bottle" => "BottleWithRedPotion",
		], $loc_item_array);
	}
}
