<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

/**
 * All Block classes are in here
 */
namespace pocketmine\block;

use pocketmine\block\Solid;
use pocketmine\entity\Entity;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\level\MovingObjectPosition;
use pocketmine\level\Position;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\metadata\Metadatable;
use pocketmine\metadata\MetadataValue;
use pocketmine\Player;
use pocketmine\plugin\Plugin;


class Block extends Position implements Metadatable {
	
	/** REDSTONE CONSTS BEGIN **/
	const REDSTONE_POWER_MIN = 0;
	const REDSTONE_POWER_MAX = 15;
	
	const DIRECTION_NONE = -1;
	const DIRECTION_BOTTOM = 0;
	const DIRECTION_TOP = 1;
	const DIRECTION_NORTH = 2;
	const DIRECTION_SOUTH = 3;
	const DIRECTION_WEST = 4;
	const DIRECTION_EAST = 5;
	const DIRECTION_SELF = 6;
	
	/** REDSTONE CONSTS END **/
	
	const FACE_DOWN = 0;
	const FACE_UP = 1;
	const FACE_NORTH = 2;
	const FACE_SOUTH = 3;
	const FACE_WEST = 4;
	const FACE_EAST = 5;

	const COLOR_WHITE = 0;
	const COLOR_ORANGE = 1;
	const COLOR_MAGENTA = 2;
	const COLOR_LIGHT_BLUE = 3;
	const COLOR_YELLOW = 4;
	const COLOR_LIME = 5;
	const COLOR_PINK = 6;
	const COLOR_GRAY = 7;
	const COLOR_LIGHT_GRAY = 8;
	const COLOR_CYAN = 9;
	const COLOR_PURPLE = 10;
	const COLOR_BLUE = 11;
	const COLOR_BROWN = 12;
	const COLOR_GREEN = 13;
	const COLOR_RED = 14;
	const COLOR_BLACK = 15;

	const AIR = 0;
	const STONE = 1;
	const GRASS = 2;
	const DIRT = 3;
	const COBBLESTONE = 4;
	const COBBLE = 4;
	const PLANK = 5;
	const PLANKS = 5;
	const WOODEN_PLANK = 5;
	const WOODEN_PLANKS = 5;
	const SAPLING = 6;
	const SAPLINGS = 6;
	const BEDROCK = 7;
	const WATER = 8;
	const STILL_WATER = 9;
	const LAVA = 10;
	const STILL_LAVA = 11;
	const SAND = 12;
	const GRAVEL = 13;
	const GOLD_ORE = 14;
	const IRON_ORE = 15;
	const COAL_ORE = 16;
	const WOOD = 17;
	const TRUNK = 17;
	const LOG = 17;
	const LEAVES = 18;
	const LEAVE = 18;
	const SPONGE = 19;
	const GLASS = 20;
	const LAPIS_ORE = 21;
	const LAPIS_BLOCK = 22;
	const DISPENSER = 23;
	const SANDSTONE = 24;
	const NOTE_BLOCK = 25;
	const BED_BLOCK = 26;
	const POWERED_RAIL = 27;
	const DETECTOR_RAIL = 28;
	const STICKY_PISTON = 29;
	const COBWEB = 30;
	const TALL_GRASS = 31;
	const BUSH = 32;
	const DEAD_BUSH = 32;
	const PISTON = 33;
	const PISTON_HEAD = 34;
	const WOOL = 35;
	// 36 doesn't exist in client (at least in 1.2.13)
	const DANDELION = 37;
	const ROSE = 38;
	const POPPY = 38;
	const RED_FLOWER = 38;
	const BROWN_MUSHROOM = 39;
	const RED_MUSHROOM = 40;
	const GOLD_BLOCK = 41;
	const IRON_BLOCK = 42;
	const DOUBLE_SLAB = 43;
	const DOUBLE_SLABS = 43;
	const SLAB = 44;
	const SLABS = 44;
	const STONE_SLAB = 44;
	const BRICKS = 45;
	const BRICKS_BLOCK = 45;
	const TNT = 46;
	const BOOKSHELF = 47;
	const MOSS_STONE = 48;
	const MOSSY_STONE = 48;
	const OBSIDIAN = 49;
	const TORCH = 50;
	const FIRE = 51;
	const MONSTER_SPAWNER = 52;
	const WOOD_STAIRS = 53;
	const WOODEN_STAIRS = 53;
	const OAK_WOOD_STAIRS = 53;
	const OAK_WOODEN_STAIRS = 53;
	const CHEST = 54;
	const REDSTONE_WIRE = 55;
	const DIAMOND_ORE = 56;
	const DIAMOND_BLOCK = 57;
	const CRAFTING_TABLE = 58;
	const WORKBENCH = 58;
	const WHEAT_BLOCK = 59;
	const FARMLAND = 60;
	const FURNACE = 61;
	const BURNING_FURNACE = 62;
	const LIT_FURNACE = 62;
	const SIGN_POST = 63;
	const DOOR_BLOCK = 64;
	const WOODEN_DOOR_BLOCK = 64;
	const WOOD_DOOR_BLOCK = 64;
	const LADDER = 65;
	const RAIL = 66;
	const COBBLE_STAIRS = 67;
	const COBBLESTONE_STAIRS = 67;
	const WALL_SIGN = 68;
	const LEVER = 69;
	const STONE_PRESSURE_PLATE = 70;
	const IRON_DOOR_BLOCK = 71;
	const WOODEN_PRESSURE_PLATE = 72;
	const REDSTONE_ORE = 73;
	const GLOWING_REDSTONE_ORE = 74;
	const LIT_REDSTONE_ORE = 74;
	const REDSTONE_TORCH = 75;
	const REDSTONE_TORCH_ACTIVE = 76;
	const STONE_BUTTON = 77;
	const SNOW = 78;
	const SNOW_LAYER = 78;
	const ICE = 79;
	const SNOW_BLOCK = 80;
	const CACTUS = 81;
	const CLAY_BLOCK = 82;
	const REEDS = 83;
	const SUGARCANE_BLOCK = 83;
	const JUKEBOX = 84;
	const FENCE = 85;
	const PUMPKIN = 86;
	const NETHERRACK = 87;
	const SOUL_SAND = 88;
	const GLOWSTONE = 89;
	const GLOWSTONE_BLOCK = 89;
	const PORTAL = 90;
	const LIT_PUMPKIN = 91;
	const JACK_O_LANTERN = 91;
	const CAKE_BLOCK = 92;
	const REDSTONE_REPEATER_BLOCK = 93;
	const REDSTONE_REPEATER_BLOCK_ACTIVE = 94;
	const INVISIBLE_BEDROCK = 95;
	const TRAPDOOR = 96;
	const WOODEN_TRAPDOOR = 96;
	const WOOD_TRAPDOOR = 96;
	const MONSTER_EGG = 97;
	const STONE_BRICKS = 98;
	const STONE_BRICK = 98;
	const STONEBRICK = 98;
	const BROWN_MUSHROOM_BLOCK = 99;
	const RED_MUSHROOM_BLOCK = 100;
	const IRON_BAR = 101;
	const IRON_BARS = 101;
	const GLASS_PANE = 102;
	const GLASS_PANEL = 102;
	const MELON_BLOCK = 103;
	const PUMPKIN_STEM = 104;
	const MELON_STEM = 105;
	const VINE = 106;
	const VINES = 106;
	const FENCE_GATE = 107;
	const BRICK_STAIRS = 108;
	const STONE_BRICK_STAIRS = 109;
	const MYCELIUM = 110;
	const WATER_LILY = 111;
	const LILY_PAD = 111;
	const NETHER_BRICKS = 112;
	const NETHER_BRICK_BLOCK = 112;
	const NETHER_BRICK_FENCE = 113;
	const NETHER_BRICKS_STAIRS = 114;
	const NETHER_WART = 115;
	const NETHER_WART_BLOCK = 115;
	const ENCHANTING_TABLE = 116;
	const ENCHANT_TABLE = 116;
	const ENCHANTMENT_TABLE = 116;
	const BREWING_STAND = 117;
	const BREWING_STAND_BLOCK = 117;
	const CAULDRON = 118;
	const CAULDRON_BLOCK = 118;
	const END_PORTAL = 119;
	const END_PORTAL_FRAME = 120;
	const END_STONE = 121;
	const DRAGON_EGG = 122;
	const REDSTONE_LAMP = 123;
	const REDSTONE_LAMP_ACTIVE = 124;
	const DROPPER = 125;
	const ACTIVATOR_RAIL = 126;
	const COCOA = 127;
	const SANDSTONE_STAIRS = 128;
	const EMERALD_ORE = 129;
    const ENDER_CHEST = 130;
	const TRIPWIRE_HOOK = 131;
	const TRIPWIRE = 132;
	const EMERALD_BLOCK = 133;
	const SPRUCE_WOOD_STAIRS = 134;
	const SPRUCE_WOODEN_STAIRS = 134;
	const BIRCH_WOOD_STAIRS = 135;
	const BIRCH_WOODEN_STAIRS = 135;
	const JUNGLE_WOOD_STAIRS = 136;
	const JUNGLE_WOODEN_STAIRS = 136;
	const COMMAND_BLOCK = 137;
	const BEACON = 138;
	const COBBLE_WALL = 139;
	const STONE_WALL = 139;
	const COBBLESTONE_WALL = 139;
	const FLOWER_POT_BLOCK = 140;
	const CARROT_BLOCK = 141;
	const POTATO_BLOCK = 142;
	const WOODEN_BUTTON = 143;
	const MOB_HEAD_BLOCK = 144;
	const ANVIL = 145;
	const TRAPPED_CHEST = 146;
	const WEIGHTED_PRESSURE_PLATE_LIGHT = 147;
	const WEIGHTED_PRESSURE_PLATE_HEAVY = 148;
	const REDSTONE_COMPARATOR_BLOCK = 149;
	const REDSTONE_COMPARATOR_BLOCK_POWERED = 150;
	const DAYLIGHT_SENSOR = 151;
	const REDSTONE_BLOCK = 152;
	const NETHER_QUARTZ_ORE = 153;
	const HOPPER_BLOCK = 154;
	const QUARTZ_BLOCK = 155;
	const QUARTZ_STAIRS = 156;
	const DOUBLE_WOOD_SLAB = 157;
	const DOUBLE_WOODEN_SLAB = 157;
	const DOUBLE_WOOD_SLABS = 157;
	const DOUBLE_WOODEN_SLABS = 157;
	const WOOD_SLAB = 158;
	const WOODEN_SLAB = 158;
	const WOOD_SLABS = 158;
	const WOODEN_SLABS = 158;
	const STAINED_CLAY = 159;
	const STAINED_HARDENED_CLAY = 159;
	const STAINED_GLASS_PANE = 160;
	const LEAVES2 = 161;
	const LEAVE2 = 161;
	const WOOD2 = 162;
	const TRUNK2 = 162;
	const LOG2 = 162;
	const ACACIA_WOOD_STAIRS = 163;
	const ACACIA_WOODEN_STAIRS = 163;
	const DARK_OAK_WOOD_STAIRS = 164;
	const DARK_OAK_WOODEN_STAIRS = 164;
	const SLIME_BLOCK = 165;
	// 166 doesn't exist in client (at least in 1.2.13)
	const IRON_TRAPDOOR = 167;
	const PRISMARINE = 168;
	const SEA_LANTERN = 169;
	const HAY_BALE = 170;
	const CARPET = 171;
	const HARDENED_CLAY = 172;
	const COAL_BLOCK = 173;
	const PACKED_ICE = 174;
	const DOUBLE_PLANT = 175;
	const STANDING_BANNER = 176;
	const WALL_BANNER = 177;
	const INVERTED_DAYLIGHT_SENSOR = 178;
	const RED_SANDSTONE = 179;
	const RED_SANDSTONE_STAIRS = 180;
	const DOUBLE_RED_SANDSTONE_SLAB = 181;
	const RED_SANDSTONE_SLAB = 182;
	const FENCE_GATE_SPRUCE = 183;
	const FENCE_GATE_BIRCH = 184;
	const FENCE_GATE_JUNGLE = 185;
	const FENCE_GATE_DARK_OAK = 186;
	const FENCE_GATE_ACACIA = 187;
	const REPEATING_COMMAND_BLOCK = 188;
	const CHAIN_COMMAND_BLOCK = 189;
	// 190 - 192 doesn't exist in client (at least in 1.2.13)
	const SPRUCE_DOOR_BLOCK = 193;
	const BIRCH_DOOR_BLOCK = 194;
	const JUNGLE_DOOR_BLOCK = 195;
	const ACACIA_DOOR_BLOCK = 196;
	const DARK_OAK_DOOR_BLOCK = 197;
	const GRASS_PATH = 198;
	const ITEM_FRAME = 199;
	const ITEM_FRAME_BLOCK = 199;
    const CHORUS_FLOWER = 200;
	const PURPUR_BLOCK = 201;
	// 202, 204 doesn't exist in client (at least in 1.2.13)
	const PURPUR_STAIRS = 203;
	const UNDYED_SHULKER_BOX = 205;
	const END_BRICKS = 206;
	const FROSTED_ICE = 207;
    const END_ROD = 208;
	const END_GATEWAY = 209;
	// 210 - 212 doesn't exist in client (at least in 1.2.13)
	const MAGMA = 213;
	const NETHER_WART_BLOCK_BLOCK = 214;
	const RED_NETHER_BRICK = 215;
	const RED_NETHER_BRICKS = 215;
	const BONE_BLOCK = 216;
	// 217 doesn't exist in client (at least in 1.2.13)
	const SHULKER_BOX = 218;
	const PURPLE_GLAZED_TERRACOTTA = 219;
	const WHITE_GLAZED_TERRACOTTA = 220;
	const ORANGE_GLAZED_TERRACOTTA = 221;
	const MAGENTA_GLAZED_TERRACOTTA = 222;
	const LIGHT_BLUE_GLAZED_TERRACOTTA = 223;
	const YELLOW_GLAZED_TERRACOTTA = 224;
	const LIME_GLAZED_TERRACOTTA = 225;
	const PINK_GLAZED_TERRACOTTA = 226;
	const GRAY_GLAZED_TERRACOTTA = 227;
	const SILVER_GLAZED_TERRACOTTA = 228;
	const CYAN_GLAZED_TERRACOTTA = 229;
	// 230 doesn't exist in client (at least in 1.2.13)
	const BLUE_GLAZED_TERRACOTTA = 231;
	const BROWN_GLAZED_TERRACOTTA = 232;
	const GREEN_GLAZED_TERRACOTTA = 233;
	const RED_GLAZED_TERRACOTTA = 234;
	const BLACK_GLAZED_TERRACOTTA = 235;
    const CONCRETE = 236;
	const CONCRETE_POWDER = 237;
	// 238 - 239 doesn't exist in client (at least in 1.2.13)
    const CHORUS_PLANT = 240;
	const STAINED_GLASS = 241;
	// 242 doesn't exist in client (at least in 1.2.13)
	const PODZOL = 243;
	const BEETROOT_BLOCK = 244;
	const STONECUTTER = 245;
	const GLOWING_OBSIDIAN = 246;
	const NETHER_REACTOR = 247;
	const UPDATE_GAME_1 = 248;
	const UPDATE_GAME_2 = 249;
	const MOVING_BLOCK = 250;
	const OBSERVER = 251;
	const STRUCTURE_BLOCK = 252;
	// 253 - 254 doesn't exist in client (at least in 1.2.13)
	const RESERVER_6 = 255;

	/** @var \SplFixedArray */
	public static $list = null;
	/** @var \SplFixedArray */
	public static $fullList = null;

	/** @var \SplFixedArray */
	public static $light = null;
	/** @var \SplFixedArray */
	public static $lightFilter = null;
	/** @var \SplFixedArray */
	public static $solid = null;
	/** @var \SplFixedArray */
	public static $liquid= null;
	/** @var \SplFixedArray */
	public static $hardness = null;
	/** @var \SplFixedArray */
	public static $transparent = null;

	protected $id;
	protected $meta = 0;

	/** @var AxisAlignedBB */
	public $boundingBox = null;

	/**
	 * Backwards-compatibility with old way to define block properties
	 *
	 * @deprecated
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get($key){
		static $map = [
			"hardness" => "getHardness",
			"lightLevel" => "getLightLevel",
			"name" => "getName",
			"isPlaceable" => "canBePlaced",
			"isReplaceable" => "canBeReplaced",
			"isTransparent" => "isTransparent",
			"isSolid" => "isSolid",
			"isFlowable" => "canBeFlowedInto",
			"isActivable" => "canBeActivated",
			"hasEntityCollision" => "hasEntityCollision"
		];
		return isset($map[$key]) ? $this->{$map[$key]}() : null;
	}

	public static function init(){
		if(self::$list === null){
			self::$list = new \SplFixedArray(256);
			self::$fullList = new \SplFixedArray(4096);
			self::$light = new \SplFixedArray(256);
			self::$lightFilter = new \SplFixedArray(256);
			self::$solid = new \SplFixedArray(256);
			self::$liquid = new \SplFixedArray(256);
			self::$hardness = new \SplFixedArray(256);
			self::$transparent = new \SplFixedArray(256);
			self::$list[self::AIR] = Air::class;
			self::$list[self::STONE] = Stone::class;
			self::$list[self::GRASS] = Grass::class;
			self::$list[self::DIRT] = Dirt::class;
			self::$list[self::COBBLESTONE] = Cobblestone::class;
			self::$list[self::PLANKS] = Planks::class;
			self::$list[self::SAPLING] = Sapling::class;
			self::$list[self::BEDROCK] = Bedrock::class;
			self::$list[self::WATER] = Water::class;
			self::$list[self::STILL_WATER] = StillWater::class;
			self::$list[self::LAVA] = Lava::class;
			self::$list[self::STILL_LAVA] = StillLava::class;
			self::$list[self::SAND] = Sand::class;
			self::$list[self::GRAVEL] = Gravel::class;
			self::$list[self::GOLD_ORE] = GoldOre::class;
			self::$list[self::IRON_ORE] = IronOre::class;
			self::$list[self::COAL_ORE] = CoalOre::class;
			self::$list[self::WOOD] = Wood::class;
			self::$list[self::LEAVES] = Leaves::class;
			self::$list[self::SPONGE] = Sponge::class;
			self::$list[self::GLASS] = Glass::class;
			self::$list[self::LAPIS_ORE] = LapisOre::class;
			self::$list[self::LAPIS_BLOCK] = Lapis::class;
			self::$list[self::SANDSTONE] = Sandstone::class;
			self::$list[self::RED_SANDSTONE] = RedSandstone::class;
			self::$list[self::BED_BLOCK] = Bed::class;
			self::$list[self::COBWEB] = Cobweb::class;
			self::$list[self::TALL_GRASS] = TallGrass::class;
			self::$list[self::DEAD_BUSH] = DeadBush::class;
			self::$list[self::WOOL] = Wool::class;
			self::$list[self::DANDELION] = Dandelion::class;
			self::$list[self::RED_FLOWER] = Flower::class;
			self::$list[self::BROWN_MUSHROOM] = BrownMushroom::class;
			self::$list[self::RED_MUSHROOM] = RedMushroom::class;
			self::$list[self::GOLD_BLOCK] = Gold::class;
			self::$list[self::IRON_BLOCK] = Iron::class;
			self::$list[self::DOUBLE_SLAB] = DoubleSlab::class;
			self::$list[self::SLAB] = Slab::class;
			self::$list[self::BRICKS_BLOCK] = Bricks::class;
			self::$list[self::TNT] = TNT::class;
			self::$list[self::BOOKSHELF] = Bookshelf::class;
			self::$list[self::MOSS_STONE] = MossStone::class;
			self::$list[self::OBSIDIAN] = Obsidian::class;
			self::$list[self::TORCH] = Torch::class;
			self::$list[self::FIRE] = Fire::class;
			self::$list[self::MONSTER_SPAWNER] = MonsterSpawner::class;
			self::$list[self::WOOD_STAIRS] = WoodStairs::class;
			self::$list[self::CHEST] = Chest::class;

			self::$list[self::DIAMOND_ORE] = DiamondOre::class;
			self::$list[self::DIAMOND_BLOCK] = Diamond::class;
			self::$list[self::WORKBENCH] = Workbench::class;
			self::$list[self::WHEAT_BLOCK] = Wheat::class;
			self::$list[self::FARMLAND] = Farmland::class;
			self::$list[self::FURNACE] = Furnace::class;
			self::$list[self::BURNING_FURNACE] = BurningFurnace::class;
			self::$list[self::SIGN_POST] = SignPost::class;
			self::$list[self::WOOD_DOOR_BLOCK] = WoodDoor::class;
			self::$list[self::SPRUCE_DOOR_BLOCK] = SpruceDoor::class;
			self::$list[self::LADDER] = Ladder::class;
			self::$list[self::RAIL] = Rail::class;
			self::$list[self::COBBLESTONE_STAIRS] = CobblestoneStairs::class;
			self::$list[self::WALL_SIGN] = WallSign::class;

			self::$list[self::IRON_DOOR_BLOCK] = IronDoor::class;
			self::$list[self::REDSTONE_ORE] = RedstoneOre::class;
			self::$list[self::GLOWING_REDSTONE_ORE] = GlowingRedstoneOre::class;

			self::$list[self::SNOW_LAYER] = SnowLayer::class;
			self::$list[self::ICE] = Ice::class;
			self::$list[self::SNOW_BLOCK] = Snow::class;
			self::$list[self::CACTUS] = Cactus::class;
			self::$list[self::CLAY_BLOCK] = Clay::class;
			self::$list[self::SUGARCANE_BLOCK] = Sugarcane::class;

			self::$list[self::FENCE] = Fence::class;
			self::$list[self::PUMPKIN] = Pumpkin::class;
			self::$list[self::NETHERRACK] = Netherrack::class;
			self::$list[self::SOUL_SAND] = SoulSand::class;
			self::$list[self::GLOWSTONE_BLOCK] = Glowstone::class;

			self::$list[self::LIT_PUMPKIN] = LitPumpkin::class;
			self::$list[self::CAKE_BLOCK] = Cake::class;

			self::$list[self::TRAPDOOR] = Trapdoor::class;
			self::$list[self::IRON_TRAPDOOR] = IronTrapdoor::class;

			self::$list[self::MONSTER_EGG] = MonsterEgg::class;
			self::$list[self::STONE_BRICKS] = StoneBricks::class;

			self::$list[self::IRON_BARS] = IronBars::class;
			self::$list[self::GLASS_PANE] = GlassPane::class;
			self::$list[self::MELON_BLOCK] = Melon::class;
			self::$list[self::PUMPKIN_STEM] = PumpkinStem::class;
			self::$list[self::MELON_STEM] = MelonStem::class;
			self::$list[self::VINE] = Vine::class;
			self::$list[self::FENCE_GATE] = FenceGate::class;
			self::$list[self::BRICK_STAIRS] = BrickStairs::class;
			self::$list[self::STONE_BRICK_STAIRS] = StoneBrickStairs::class;

			self::$list[self::MYCELIUM] = Mycelium::class;
			self::$list[self::WATER_LILY] = WaterLily::class;
			self::$list[self::NETHER_BRICKS] = NetherBrick::class;
			self::$list[self::RED_NETHER_BRICKS] = RedNetherBrick::class;
			self::$list[self::NETHER_BRICK_FENCE] = NetherBrickFence::class;

			self::$list[self::NETHER_BRICKS_STAIRS] = NetherBrickStairs::class;

			self::$list[self::ENCHANTING_TABLE] = EnchantingTable::class;

			self::$list[self::END_PORTAL_FRAME] = EndPortalFrame::class;
			self::$list[self::END_STONE] = EndStone::class;
			self::$list[self::SANDSTONE_STAIRS] = SandstoneStairs::class;
			self::$list[self::EMERALD_ORE] = EmeraldOre::class;

			self::$list[self::EMERALD_BLOCK] = Emerald::class;
			self::$list[self::SPRUCE_WOOD_STAIRS] = SpruceWoodStairs::class;
			self::$list[self::BIRCH_WOOD_STAIRS] = BirchWoodStairs::class;
			self::$list[self::JUNGLE_WOOD_STAIRS] = JungleWoodStairs::class;
			self::$list[self::STONE_WALL] = StoneWall::class;

			self::$list[self::CARROT_BLOCK] = Carrot::class;
			self::$list[self::POTATO_BLOCK] = Potato::class;
			self::$list[self::ANVIL] = Anvil::class;

			self::$list[self::REDSTONE_BLOCK] = Redstone::class;

			self::$list[self::QUARTZ_BLOCK] = Quartz::class;
			self::$list[self::QUARTZ_STAIRS] = QuartzStairs::class;
			self::$list[self::DOUBLE_WOOD_SLAB] = DoubleWoodSlab::class;
			self::$list[self::WOOD_SLAB] = WoodSlab::class;
			self::$list[self::STAINED_CLAY] = StainedClay::class;

			self::$list[self::LEAVES2] = Leaves2::class;
			self::$list[self::WOOD2] = Wood2::class;
			self::$list[self::ACACIA_WOOD_STAIRS] = AcaciaWoodStairs::class;
			self::$list[self::DARK_OAK_WOOD_STAIRS] = DarkOakWoodStairs::class;
			self::$list[self::SEA_LANTERN] = SeaLantern::class;

			self::$list[self::HAY_BALE] = HayBale::class;
			self::$list[self::CARPET] = Carpet::class;
			self::$list[self::HARDENED_CLAY] = HardenedClay::class;
			self::$list[self::COAL_BLOCK] = Coal::class;

			self::$list[self::DOUBLE_PLANT] = DoublePlant::class;

			self::$list[self::FENCE_GATE_SPRUCE] = FenceGateSpruce::class;
			self::$list[self::FENCE_GATE_BIRCH] = FenceGateBirch::class;
			self::$list[self::FENCE_GATE_JUNGLE] = FenceGateJungle::class;
			self::$list[self::FENCE_GATE_DARK_OAK] = FenceGateDarkOak::class;
			self::$list[self::FENCE_GATE_ACACIA] = FenceGateAcacia::class;

			self::$list[self::GRASS_PATH] = GrassPath::class;

			self::$list[self::PODZOL] = Podzol::class;
			self::$list[self::BEETROOT_BLOCK] = Beetroot::class;
			self::$list[self::STONECUTTER] = Stonecutter::class;
			self::$list[self::GLOWING_OBSIDIAN] = GlowingObsidian::class;
			self::$list[self::NETHER_REACTOR] = NetherReactor::class;
			
			self::$list[self::SLIME_BLOCK] = SlimeBlock::class;
			
			self::$list[self::WOODEN_BUTTON] = WoodenButton::class;
			self::$list[self::STONE_BUTTON] = StoneButton::class;
			
			self::$list[self::ACACIA_DOOR_BLOCK] = AcaciaDoor::class;
			self::$list[self::BIRCH_DOOR_BLOCK] = BirchDoor::class;
			self::$list[self::DARK_OAK_DOOR_BLOCK] = DarkOakDoor::class;
			self::$list[self::JUNGLE_DOOR_BLOCK] = JungleDoor::class;
			
			self::$list[self::TRIPWIRE] = Tripwire::class;
			self::$list[self::TRIPWIRE_HOOK] = TripwireHook::class;
			
			self::$list[self::LEVER] = Lever::class;
			
			self::$list[self::WOODEN_PRESSURE_PLATE] = WoodenPressurePlate::class;
			self::$list[self::STONE_PRESSURE_PLATE] = StonePressurePlate::class;
			
			self::$list[self::REDSTONE_WIRE] = RedstoneWire::class;
			self::$list[self::REDSTONE_REPEATER_BLOCK] = RedstoneRepeater::class;
			self::$list[self::REDSTONE_REPEATER_BLOCK_ACTIVE] = RedstoneRepeaterActive::class;
			
			self::$list[self::POWERED_RAIL] = PoweredRail::class;
			self::$list[self::DETECTOR_RAIL] = DetectorRail::class;
			self::$list[self::ACTIVATOR_RAIL] = ActivatorRail::class;
			
			self::$list[self::WEIGHTED_PRESSURE_PLATE_HEAVY] = WeightedPressurePlateHeavy::class;
			self::$list[self::WEIGHTED_PRESSURE_PLATE_LIGHT] = WeightedPressurePlateLight::class;
			
			self::$list[self::MOB_HEAD_BLOCK] = MobHead::class;
			self::$list[self::FLOWER_POT_BLOCK] = FlowerPot::class;
            
			// update 1.0
			self::$list[self::CHORUS_FLOWER] = ChorusFlower::class;
			self::$list[self::CHORUS_PLANT] = ChorusPlant::class;
			self::$list[self::ENDER_CHEST] = EnderChest::class;
			self::$list[self::END_GATEWAY] = EndGateway::class;
			self::$list[self::END_PORTAL] = EndPortal::class;
			self::$list[self::END_BRICKS] = EndBricks::class;
			self::$list[self::END_ROD] = EndRod::class;
			self::$list[self::DRAGON_EGG] = DragonEgg::class;
			self::$list[self::PURPUR_BLOCK] = PurpurBlock::class;
			self::$list[self::STAINED_GLASS] = StainedGlass::class;
			self::$list[self::STAINED_GLASS_PANE] = StainedGlassPane::class;

			self::$list[self::REDSTONE_LAMP] = RedstoneLamp::class;
			self::$list[self::REDSTONE_LAMP_ACTIVE] = RedstoneLampActive::class;
			
			self::$list[self::REDSTONE_TORCH] = RedstoneTorch::class;
			self::$list[self::REDSTONE_TORCH_ACTIVE] = RedstoneTorchActive::class;
			self::$list[self::PISTON] = Piston::class;
			self::$list[self::PISTON_HEAD] = PistonHead::class;
			self::$list[self::STICKY_PISTON] = StickyPiston::class;
			
			self::$list[self::DROPPER] = Dropper::class;
			self::$list[self::DISPENSER] = Dispenser::class;
			self::$list[self::HOPPER_BLOCK] = Hopper::class;
			
			self::$list[self::REDSTONE_COMPARATOR_BLOCK] = RedstoneComparator::class;
			self::$list[self::TRAPPED_CHEST] = TrappedChest::class;
			
			self::$list[self::PORTAL] = Portal::class;

			self::$list[self::CONCRETE] = Concrete::class;
			self::$list[self::CONCRETE_POWDER] = ConcretePowder::class;
			
			self::$list[self::SHULKER_BOX] = ShulkerBox::class;
			self::$list[self::PRISMARINE] = Prismarine::class;
			
			self::$list[self::NOTE_BLOCK] = NoteBlock::class;
			self::$list[self::JUKEBOX] = Jukebox::class;
			self::$list[self::PORTAL] = Portal::class;
			
			self::$list[self::BROWN_MUSHROOM_BLOCK] = MushroomBlock::class;
			self::$list[self::RED_MUSHROOM_BLOCK] = MushroomBlock::class;
			
			self::$list[self::NETHER_WART] = NetherWart::class;
			self::$list[self::BREWING_STAND] = BrewingStand::class;
			self::$list[self::CAULDRON] = Cauldron::class;
			self::$list[self::COCOA] = Cocoa::class;
			self::$list[self::BEACON] = Beacon::class;
			self::$list[self::PACKED_ICE] = PackedIce::class;
			self::$list[self::STANDING_BANNER] = StandingBanner::class;
			self::$list[self::WALL_BANNER] = WallBanner::class;
			self::$list[self::RED_SANDSTONE] = RedSandstone::class;
			self::$list[self::RED_SANDSTONE_STAIRS] = RedSandstoneStairs::class;
			self::$list[self::ITEM_FRAME_BLOCK] = ItemFrame::class;
			self::$list[self::PURPUR_STAIRS] = PurpurStairs::class;
			self::$list[self::UNDYED_SHULKER_BOX] = UndyedShulkerBox::class;
			self::$list[self::FROSTED_ICE] = FrostedIce::class;
			self::$list[self::RED_NETHER_BRICK] = RedNetherBrick::class;
			self::$list[self::BONE_BLOCK] = BoneBlock::class;
            
			self::$list[self::PURPLE_GLAZED_TERRACOTTA] = PurpleGlazedTerracotta::class;
			self::$list[self::WHITE_GLAZED_TERRACOTTA] = WhiteGlazedTerracotta::class;
			self::$list[self::ORANGE_GLAZED_TERRACOTTA] = OrangeGlazedTerracotta::class;
			self::$list[self::MAGENTA_GLAZED_TERRACOTTA] = MagentaGlazedTerracotta::class;
			self::$list[self::LIGHT_BLUE_GLAZED_TERRACOTTA] = LightBlueGlazedTerracotta::class;
			self::$list[self::YELLOW_GLAZED_TERRACOTTA] = YellowGlazedTerracotta::class;
			self::$list[self::LIME_GLAZED_TERRACOTTA] = LimeGlazedTerracotta::class;
			self::$list[self::PINK_GLAZED_TERRACOTTA] = PinkGlazedTerracotta::class;
			self::$list[self::GRAY_GLAZED_TERRACOTTA] = GrayGlazedTerracotta::class;
			self::$list[self::SILVER_GLAZED_TERRACOTTA] = LightGrayGlazedTerracotta::class;
			self::$list[self::CYAN_GLAZED_TERRACOTTA] = CyanGlazedTerracotta::class;
			self::$list[self::BLUE_GLAZED_TERRACOTTA] = BlueGlazedTerracotta::class;
			self::$list[self::BROWN_GLAZED_TERRACOTTA] = BrownGlazedTerracotta::class;
			self::$list[self::GREEN_GLAZED_TERRACOTTA] = GreenGlazedTerracotta::class;
			self::$list[self::RED_GLAZED_TERRACOTTA] = RedGlazedTerracotta::class;
			self::$list[self::BLACK_GLAZED_TERRACOTTA] = BlackGlazedTerracotta::class;

			self::$list[self::MAGMA] = Magma::class;
			
			foreach (self::$list as $id => $class) {
				static::registerBlock($id, $class);
			}
		}
	}

	public static function registerBlock($id, $class) {
		if (self::$list[$id] != $class) {
			self::$list[$id] = $class;
		}
		if ($class !== null) {
			/** @var Block $block */
			$block = new $class();

			for ($data = 0; $data < 16; ++$data) {
				self::$fullList[($id << 4) | $data] = new $class($data);
			}

			self::$solid[$id] = $block->isSolid();
			self::$transparent[$id] = $block->isTransparent();
			self::$hardness[$id] = $block->getHardness();
			self::$light[$id] = $block->getLightLevel();
			self::$liquid[$id] = $block->isLiquid();

			if ($block->isSolid()) {
				if ($block->isTransparent()) {
					if ($block instanceof Liquid or $block instanceof Ice) {
						self::$lightFilter[$id] = 2;
					} else {
						self::$lightFilter[$id] = 1;
					}
				} else {
					self::$lightFilter[$id] = 15;
				}
			} else {
				self::$lightFilter[$id] = 1;
			}
		} else {
			self::$lightFilter[$id] = 1;
			for ($data = 0; $data < 16; ++$data) {
				self::$fullList[($id << 4) | $data] = new Block($id, $data);
			}
		}
	}

	/**
	 * @param int      $id
	 * @param int      $meta
	 * @param Position $pos
	 *
	 * @return Block
	 */
	public static function get($id, $meta = 0, Position $pos = null){
		try{
			$block = self::$list[$id];
			if($block !== null){
				$block = new $block($meta);
			}else{
				$block = new Block($id, $meta);
			}
		}catch(\RuntimeException $e){
			$block = new Block($id, $meta);
		}

		if($pos !== null){
			$block->x = $pos->x;
			$block->y = $pos->y;
			$block->z = $pos->z;
			$block->level = $pos->level;
		}

		return $block;
	}

	/**
	 * @param int $id
	 * @param int $meta
	 */
	public function __construct($id, $meta = 0){
		$this->id = (int) $id;
		$this->meta = (int) $meta;
	}

	/**
	 * Places the Block, using block space and block target, and side. Returns if the block has been placed.
	 *
	 * @param Item   $item
	 * @param Block  $block
	 * @param Block  $target
	 * @param int    $face
	 * @param float  $fx
	 * @param float  $fy
	 * @param float  $fz
	 * @param Player $player = null
	 *
	 * @return bool
	 */
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		return $this->getLevel()->setBlock($this, $this, true, true);
	}

	/**
	 * Returns if the item can be broken with an specific Item
	 *
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isBreakable(Item $item){
		return true;
	}

	/**
	 * Do the actions needed so the block is broken with the Item
	 *
	 * @param Item $item
	 *
	 * @return mixed
	 */
	public function onBreak(Item $item){
		return $this->getLevel()->setBlock($this, new Air(), true, true);
	}

	/**
	 * Fires a block update on the Block
	 *
	 * @param int $type
	 *
	 * @return void
	 */
	
	public function onUpdate($type, $deep){
		if ($deep > 0 && ($this->needScheduleOnUpdate())) {
			$this->level->scheduleUpdate($this, 4, $type);
			return false;
		}
		return true;
	}
	
	public function needScheduleOnUpdate() {
		return false;
	}
	


	/**
	 * Do actions when activated by Item. Returns if it has done anything
	 *
	 * @param Item   $item
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function onActivate(Item $item, Player $player = null){
		return false;
	}

	/**
	 * @return int
	 */
	public function getHardness(){
		return 10;
	}

	/**
	 * @return int
	 */
	public function getResistance(){
		return $this->getHardness() * 5;
	}

	/**
	 * @return int
	 */
	public function getToolType(){
		return Tool::TYPE_NONE;
	}

	/**
	 * @return float
	 */
	public static function getFrictionFactor(){
		return 0.6;
	}

	/**
	 * @return int 0-15
	 */
	public function getLightLevel(){
		return 0;
	}

	/**
	 * AKA: Block->isPlaceable
	 *
	 * @return bool
	 */
	public function canBePlaced(){
		return true;
	}

	/**
	 * AKA: Block->canBeReplaced()
	 *
	 * @return bool
	 */
	public function canBeReplaced(){
		return false;
	}

	/**
	 * @return bool
	 */
	public function isTransparent(){
		return false;
	}

	public function isSolid(){
		return false;
	}
	
	public function isMayBeDestroyedByPiston() {
		return false;
	}
	
	public function isLiquid() {
		return false;
	}

	/**
	 * AKA: Block->isFlowable
	 *
	 * @return bool
	 */
	public function canBeFlowedInto(){
		return false;
	}

	/**
	 * AKA: Block->isActivable
	 *
	 * @return bool
	 */
	public function canBeActivated(){
		return false;
	}

	public function hasEntityCollision(){
		return false;
	}

	public function canPassThrough(){
		return false;
	}

	/**
	 * @return string
	 */
	public function getName(){
		return "Unknown";
	}

	/**
	 * @return int
	 */
	final public function getId(){
		return $this->id;
	}

	public function addVelocityToEntity(Entity $entity, Vector3 $vector){

	}

	/**
	 * @return int
	 */
	final public function getDamage(){
		return $this->meta;
	}

	/**
	 * @param int $meta
	 */
	final public function setDamage($meta){
		$this->meta = $meta & 0x0f;
	}

	/**
	 * Sets the block position to a new Position object
	 *
	 * @param Position $v
	 */
	final public function position(Position $v){
		$this->x = (int) $v->x;
		$this->y = (int) $v->y;
		$this->z = (int) $v->z;
		$this->level = $v->level;
		$this->boundingBox = null;
	}

	/**
	 * Returns an array of Item objects to be dropped
	 *
	 * @param Item $item
	 *
	 * @return array
	 */
	public function getDrops(Item $item){
		if(!isset(self::$list[$this->getId()])){ //Unknown blocks
			return [];
		}else{
			return [
				[$this->getId(), $this->getDamage(), 1],
			];
		}
	}

	/**
	 * Returns the seconds that this block takes to be broken using an specific Item
	 *
	 * Not implemented:
	 *  - enchantment effects (Efficiency)
	 *  - status effect on player (haste, mining fatigue)
	 *  - player not on ground, player in water
	 * 
	 * @param Item $item
	 *
	 * @return float
	 */
	public function getBreakTime(Item $item) {
		static $tierMultipliers = [
			Tool::TIER_WOODEN => 2,
			Tool::TIER_STONE => 4,
			Tool::TIER_IRON => 6,
			Tool::TIER_DIAMOND => 8,
			Tool::TIER_GOLD => 12,
		];
		
		/** @docs http://minecraft.gamepedia.com/Breaking */
		if (!$this->canBeBrokenWith($item)) {
			return -1;
		}
		$toolType = $this->getToolType();
		$isSuitableForHarvest = ($this->getId() != Block::QUARTZ_BLOCK || $item->isPickaxe()) && (!empty($this->getDrops($item)) || $toolType == Tool::TYPE_NONE);
		$secondsForBreak = $this->getHardness() * ($isSuitableForHarvest ? 1.5 : 5);
		if ($secondsForBreak == 0) {
			$secondsForBreak = 0.05;
		}
		
		switch ($toolType) {
			case Tool::TYPE_SWORD:
				if ($item->isSword()) {
					if ($this->id == self::COBWEB) {
						$secondsForBreak = $secondsForBreak / 15;
					}
					return $secondsForBreak;
				}
				break;
			case Tool::TYPE_SHEARS:
				if ($item->isShears()) {
					if ($this->id == self::WOOL) {
						// line below is simplification of $baseTime = $baseTime * 1.5 / 5
						$secondsForBreak = $secondsForBreak / 5;
					} else {
						$secondsForBreak = $secondsForBreak / 15;
					}
					return $secondsForBreak;
				}
				break;
			case Tool::TYPE_SHOVEL:
				$tier = $item->isShovel();
				if ($tier !== false && isset($tierMultipliers[$tier])) {
					return $secondsForBreak / $tierMultipliers[$tier];
				}
				break;
			case Tool::TYPE_PICKAXE:
				$tier = $item->isPickaxe();
				if ($tier !== false && isset($tierMultipliers[$tier])) {
					$multiplier = $tierMultipliers[$tier];
					$ench = $item->getEnchantment(Enchantment::TYPE_MINING_EFFICIENCY);
					if (!is_null($ench)) {
						$enchLevel = $ench->getLevel();
						if ($enchLevel > 0) {
							$multiplier += $enchLevel ** 2 + 1;
						}
					}
					return $secondsForBreak / $multiplier;
				}
				break;
			case Tool::TYPE_AXE:
				$tier = $item->isAxe();
				if ($tier !== false && isset($tierMultipliers[$tier])) {
					return $secondsForBreak / $tierMultipliers[$tier];
				}
				break;
		}
		
		return $secondsForBreak;
	}

	public function canBeBrokenWith(Item $item){
		return $this->getHardness() !== -1;
	}

	/**
	 * Returns the Block on the side $side, works like Vector3::side()
	 *
	 * @param int $side
	 * @param int $step
	 *
	 * @return Block
	 */
	public function getSide($side, $step = 1){
		if($this->isValid()){
			return $this->getLevel()->getBlock(Vector3::getSide($side, $step));
		}

		return Block::get(Item::AIR, 0, Position::fromObject(Vector3::getSide($side, $step)));
	}

	/**
	 * @return string
	 */
	public function __toString(){
		return "Block[" . $this->getName() . "] (" . $this->getId() . ":" . $this->getDamage() . ") [ x: " . $this->x . ", y: " . $this->y . ", z: " . $this->z . " ]";
	}

	/**
	 * Checks for collision against an AxisAlignedBB
	 *
	 * @param AxisAlignedBB $bb
	 *
	 * @return bool
	 */
	public function collidesWithBB(AxisAlignedBB $bb){
		$bb2 = $this->getBoundingBox();

		return $bb2 !== null && $bb->intersectsWith($bb2);
	}

	/**
	 * @param Entity $entity
	 */
	public function onEntityCollide(Entity $entity){

	}

	/**
	 * @return AxisAlignedBB
	 */
	public function getBoundingBox(){
		if($this->boundingBox === null){
			$this->boundingBox = $this->recalculateBoundingBox();
		}
		return $this->boundingBox;
	}

	/**
	 * @return AxisAlignedBB
	 */
	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + 1,
			$this->z + 1
		);
	}

	/**
	 * @param Vector3 $pos1
	 * @param Vector3 $pos2
	 *
	 * @return MovingObjectPosition
	 */
	public function calculateIntercept(Vector3 $pos1, Vector3 $pos2){
		$bb = $this->getBoundingBox();
		if($bb === null){
			return null;
		}

		$v1 = $pos1->getIntermediateWithXValue($pos2, $bb->minX);
		$v2 = $pos1->getIntermediateWithXValue($pos2, $bb->maxX);
		$v3 = $pos1->getIntermediateWithYValue($pos2, $bb->minY);
		$v4 = $pos1->getIntermediateWithYValue($pos2, $bb->maxY);
		$v5 = $pos1->getIntermediateWithZValue($pos2, $bb->minZ);
		$v6 = $pos1->getIntermediateWithZValue($pos2, $bb->maxZ);

		if($v1 !== null and !$bb->isVectorInYZ($v1)){
			$v1 = null;
		}

		if($v2 !== null and !$bb->isVectorInYZ($v2)){
			$v2 = null;
		}

		if($v3 !== null and !$bb->isVectorInXZ($v3)){
			$v3 = null;
		}

		if($v4 !== null and !$bb->isVectorInXZ($v4)){
			$v4 = null;
		}

		if($v5 !== null and !$bb->isVectorInXY($v5)){
			$v5 = null;
		}

		if($v6 !== null and !$bb->isVectorInXY($v6)){
			$v6 = null;
		}

		$vector = $v1;

		if($v2 !== null and ($vector === null or $pos1->distanceSquared($v2) < $pos1->distanceSquared($vector))){
			$vector = $v2;
		}

		if($v3 !== null and ($vector === null or $pos1->distanceSquared($v3) < $pos1->distanceSquared($vector))){
			$vector = $v3;
		}

		if($v4 !== null and ($vector === null or $pos1->distanceSquared($v4) < $pos1->distanceSquared($vector))){
			$vector = $v4;
		}

		if($v5 !== null and ($vector === null or $pos1->distanceSquared($v5) < $pos1->distanceSquared($vector))){
			$vector = $v5;
		}

		if($v6 !== null and ($vector === null or $pos1->distanceSquared($v6) < $pos1->distanceSquared($vector))){
			$vector = $v6;
		}

		if($vector === null){
			return null;
		}

		$f = -1;

		if($vector === $v1){
			$f = 4;
		}elseif($vector === $v2){
			$f = 5;
		}elseif($vector === $v3){
			$f = 0;
		}elseif($vector === $v4){
			$f = 1;
		}elseif($vector === $v5){
			$f = 2;
		}elseif($vector === $v6){
			$f = 3;
		}

		return MovingObjectPosition::fromBlock($this->x, $this->y, $this->z, $f, $vector->add($this->x, $this->y, $this->z));
	}

	public function setMetadata($metadataKey, MetadataValue $metadataValue){
		if($this->getLevel() instanceof Level){
			$this->getLevel()->getBlockMetadata()->setMetadata($this, $metadataKey, $metadataValue);
		}
	}

	public function getMetadata($metadataKey){
		if($this->getLevel() instanceof Level){
			return $this->getLevel()->getBlockMetadata()->getMetadata($this, $metadataKey);
		}

		return null;
	}

	public function hasMetadata($metadataKey){
		if($this->getLevel() instanceof Level){
			$this->getLevel()->getBlockMetadata()->hasMetadata($this, $metadataKey);
		}
	}

	public function removeMetadata($metadataKey, Plugin $plugin){
		if($this->getLevel() instanceof Level){
			$this->getLevel()->getBlockMetadata()->removeMetadata($this, $metadataKey, $plugin);
		}
	}
	
	public function getPoweredState() {
		return 0; /** @see Solid::POWERED_NONE */
	}
	
	final public function isConnectedWithWireFromSide($side) {
		switch ($side) {
			case Vector3::SIDE_NORTH:
				if ($this->level->getBlockIdAt($this->x, $this->y, $this->z - 1) == self::REDSTONE_WIRE) {
					return self::isHaveWireOnSide(Vector3::SIDE_WEST, $this->x, $this->y, $this->z - 1) && 
						self::isHaveWireOnSide(Vector3::SIDE_EAST, $this->x, $this->y, $this->z - 1);
				}
				break;
			case Vector3::SIDE_SOUTH:
				if ($this->level->getBlockIdAt($this->x, $this->y, $this->z + 1) == self::REDSTONE_WIRE) {
					return self::isHaveWireOnSide(Vector3::SIDE_WEST, $this->x, $this->y, $this->z + 1) && 
						self::isHaveWireOnSide(Vector3::SIDE_EAST, $this->x, $this->y, $this->z + 1);
				}
				break;
			case Vector3::SIDE_WEST:
				if ($this->level->getBlockIdAt($this->x - 1, $this->y, $this->z) == self::REDSTONE_WIRE) {
					return self::isHaveWireOnSide(Vector3::SIDE_NORTH, $this->x - 1, $this->y, $this->z) && 
						self::isHaveWireOnSide(Vector3::SIDE_SOUTH, $this->x - 1, $this->y, $this->z);
				}
				break;
			case Vector3::SIDE_EAST:
				if ($this->level->getBlockIdAt($this->x + 1, $this->y, $this->z) == self::REDSTONE_WIRE) {
					return self::isHaveWireOnSide(Vector3::SIDE_NORTH, $this->x + 1, $this->y, $this->z) && 
						self::isHaveWireOnSide(Vector3::SIDE_SOUTH, $this->x + 1, $this->y, $this->z);
				}
				break;
		}
		return false;
	}
	
	private static function isHaveWireOnSide($side, $x, $y, $z) {
		static $offsets = [
			Vector3::SIDE_NORTH => [ 0, 0, -1],
			Vector3::SIDE_SOUTH => [ 0, 0, 1],
			Vector3::SIDE_WEST => [ -1, 0, 0],
			Vector3::SIDE_EAST => [ 1, 0, 0],
		];
		
		if (!isset($offsets[$side])) {
			return false;
		}
		$x = $x + $offsets[$side][0];
		$y = $y + $offsets[$side][1];
		$z = $z + $offsets[$side][2];
		
		$blockId = $this->level->getBlockIdAt($x, $y, $z);
		if ($blockId == self::REDSTONE_WIRE) {
			return true;
		}
		if (self::$solid[$blockId] || self::$transparent[$blockId]) {
			$blockAboveId = $this->level->getBlockIdAt($x, $y + 1, $z);
			if ($blockAboveId == self::REDSTONE_WIRE) {
				return true;
			}
		}
		if (self::$transparent[$blockId]) {
			$blockBelowId = $this->level->getBlockIdAt($x, $y - 1, $z);
			if ($blockBelowId == self::REDSTONE_WIRE) {
				return true;
			}
		}
		return false;
	}
	
	public function isCharged() {
		switch ($this->id) {
			case self::REDSTONE_WIRE:
				return $this->meta > 0;
			case self::REDSTONE_TORCH_ACTIVE:
				return true;
			case self::WOODEN_PRESSURE_PLATE:
			case self::STONE_PRESSURE_PLATE:
			case self::WEIGHTED_PRESSURE_PLATE_LIGHT:
			case self::WEIGHTED_PRESSURE_PLATE_HEAVY:
			case self::LEVER:
				return $this->isActive();
			default:
				return self::$solid[$this->id] && $this->getPoweredState() != Solid::POWERED_NONE;
		}
	}

	protected function getColorNameByMeta($meta) {
		static $colors = [
			self::COLOR_WHITE => "White",
			self::COLOR_ORANGE => "Orange",
			self::COLOR_MAGENTA => "Magenta",
			self::COLOR_LIGHT_BLUE => "Light Blue",
			self::COLOR_YELLOW => "Yellow",
			self::COLOR_LIME => "Lime",
			self::COLOR_PINK => "Pink",
			self::COLOR_GRAY => "Gray",
			self::COLOR_LIGHT_GRAY => "Light Gray",
			self::COLOR_CYAN => "Cyan",
			self::COLOR_PURPLE => "Purple",
			self::COLOR_BLUE => "Blue",
			self::COLOR_BROWN => "Brown",
			self::COLOR_GREEN => "Green",
			self::COLOR_RED => "Red",
			self::COLOR_BLACK => "Black"
		];
		return $colors[$meta & 0x0f];
	}
	
	public function getMaxStackSize() {
		return 64;
	}
	
	public function getCustomName() {
		return '';
	}
	
}
