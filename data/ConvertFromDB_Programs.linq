<Query Kind="Program">
  <Namespace>System.CodeDom.Compiler</Namespace>
  <Namespace>System.CodeDom</Namespace>
</Query>

Encoding ENC = new UTF8Encoding(false);

void Main()
{
	Do(1, "All in One", "All in One", 1439, "Tool", 1, 1, 1, "German", "Delphi", "A little \"swiss army knife\" programm with over 100 different functionalities", "2008-11-26", "direkt", "", "", "", 0, "", -1);
	Do(2, "Beepster", "Beepster", 1960, "Hoax", 0, 1, 1, "English", "Delphi", "Annoy your teachers/freinds with a very high pitched sound, even without external speakers.", "2008-06-04", "direkt", "", "", "", 0, "", -1);
	Do(3, "Blitzer", "Blitzer", 1869, "Hoax", 0, 1, 1, "English", "Delphi", "Hoax you teachers/friends with flashing lights on your monitor.", "2008-05-05", "direkt", "", "", "", 0, "", -1);
	Do(4, "Deal or no Deal", "Deal or no Deal", 1279, "Game", 0, 1, 1, "German", "Delphi", "A digital version of the same-named german tv-show game.", "2008-10-08", "direkt", "", "", "", 0, "", -1);
	Do(5, "exeExtract", "exe Extract", 1818, "Tool", 0, 1, 1, "English", "Delphi", "A simple tool to copy all files of a specific extension from a folder.", "2008-03-26", "direkt", "", "", "", 0, "", -1);
	Do(6, "Graveyard of Numbers", "G. o. N.", 1221, "Tool", 0, 1, 1, "German", "Delphi", "A little tool to continuously rename files.", "2008-10-01", "direkt", "", "", "", 0, "", -1);
	Do(7, "LightShow", "LightShow", 1888, "Hoax", 0, 1, 1, "German", "Delphi", "Turn you keyboard-LED\"s into a little lightshow", "2008-10-12", "direkt", "", "", "", 0, "", -1);
	//Do(8, "Penner-Bot", "Penner Bot", 3722, "Bot", 0, 0, 0, "German", "C++", "Cheat in the browsergame \"Pennergame\" and get a lot of Bottles free.", "2008-10-22", "direkt", "", "", "", 0, "", -1);
	Do(9, "Ziegenproblem", "Ziegenproblem", 2257, "Mathematics", 0, 1, 1, "German", "Delphi", "Simulate the popular Monty Hall problem (ger: Ziegenproblem) with this program for yourself.", "2008-04-10", "direkt", "", "", "", 0, "", -1);
	//Do(10, "Niripsa", "Niripsa", 1604, "Game", 1, 1, 0, "German", "Delphi", "A clone of the game \"Aspirin\" in space.", "2008-11-19", "direkt", "", "", "", 0, "", -1);
	Do(11, "NedSchend", "Nedschend", 1563, "Hoax", 1, 1, 1, "German", "Delphi", "Send anonymous messages over the Windows Messenger service to other pc\"s in your LAN", "2009-02-11", "direkt", "", "", "", 0, "", -1);
	Do(12, "Sieb des Eratosthenes", "Sieb des E.", 1671, "Mathematics", 1, 1, 1, "German", "Delphi", "Visualize the prime number calculation with the Sieve of Erastothenes algorithm.", "2009-01-22", "direkt", "", "", "", 0, "", -1);
	Do(13, "Logistixx", "Logistixx", 1599, "Mathematics", 1, 1, 1, "German", "Delphi", "Find the trick to escape the seemingly escape-proof maze.", "2008-12-20", "direkt", "", "", "", 0, "", -1);
	Do(14, "H2O", "H²O", 1953, "Game", 2, 1, 1, "English", "Delphi", "Try creating the biggest chain reaction and see yourself climb up in the global leaderboard.", "2009-01-24", "direkt", "", "", "", 0, "H²O", 2);
	Do(15, "LAN-Control", "LAN-Control", 1781, "Network administration", 1, 1, 1, "German", "Delphi", "Controll essential features of an other computer over the LAN", "2011-07-05", "direkt", "", "", "", 0, "LAN-Control", -1);
	Do(16, "Smart Directory Lister", "SDL", 1064, "Tool", 2, 1, 1, "German", "Delphi", "List all files in a folder that match a specific pattern and export them in plaintext.", "2010-01-12", "direkt", "", "", "", 0, "", -1);
	//Do(17, "Wikipedia - The Game", "Wiki Game", 318, "Game", 1, 1, 0, "German", "Delphi", "Expand your knowledge while you read trough wikipedia articles to find the way to your target.", "2010-05-29", "direkt", "", "", "", 0, "WTG", 3);
	//Do(18, "ClipCorn", "ClipCorn", 126, "Tool", 3, 0, 0, "German", "Delphi", "Collect and Organize all your movies central and portable in a database.", "2010-06-26", "direkt", "", "", "", 0, "ClipCorn", -1);
	Do(19, "Dynamic Link Fighters", "DLF", 1296, "Game", 1, 1, 1, "English|German", "Delphi", "Program your own KI and let it fight against others in a brutal deathmatch.", "2010-12-04", "direkt", "", "", "", 0, "DLF", -1);
	Do(20, "TicTacToe", "Tic Tac Toe", 1422, "Game", 1, 1, 1, "English", "Delphi", "The classical Tic-Tac-Toe, complete with perfect KI and Sourcecode.", "2011-01-19", "direkt", "", "", "", 0, "", -1);
	Do(21, "Keygen Dancer", "Keygen Dancer", 665, "Gadget", 2, 1, 1, "English", "Delphi", "40 of the best keygen themes together with a funny little keygen dance animation.", "2010-03-16", "", "", "", "", 0, "", -1);
	Do(22, "Infinity Tournament", "Inf. Tournament", 1258, "Game", 4, 1, 1, "English", "Java", "A never ending Tower Defense where you fight against your own score.", "2012-04-14", "direkt", "", "", "", 1, "InfinityTournament", 4);
	Do(23, "jCircuits", "jCircuits", 1411, "Simulation", 4, 1, 1, "English", "Java", "A fully featured logical circuit simulator with many prebuild components", "2011-12-16", "direkt", "http://sourceforge.net/projects/jcircuits/", "", "", 0, "", -1);
	Do(24, "Borderline Defense", "Borderline Defense", 1042, "Game", 4, 1, 1, "English", "Java", "A improved Space-Invaders clone - programmed from the Java-AG, Oken.", "2012-05-24", "direkt", "", "http://borderlinedefense.99k.org/", "", 1, "", 5);
	Do(25, "absCanvas", "absCanvas", 1442, "Engine", 3, 1, 1, "English", "Java", "A powerful 2D Tiled-Game-Engine for java. Completely in canvas and with network support.", "2012-05-28", "direkt", "", "", "", 0, "absCanvas", -1);
	Do(26, "Crystal Grid", "Crystal Grid", 1032, "Game", 4, 1, 1, "English", "Java", "A challenging, tactical mini-game in blueprint-style.", "2013-01-03", "direkt", "", "", "", 1, "CrystalGrid", 6);
	Do(28, "jClipCorn", "jClipCorn", 432, "Tool", 4, 1, 1, "English|German", "Java", "Organize your movies and series on an external hard drive.", "2012-10-28", "https://github.com/Mikescher/jClipCorn/releases", "", "", "https://github.com/Mikescher/jClipCorn/wiki", 0, "jClipCorn", -1);
	Do(29, "BefunZ", "BefunZ", 1005, "Interpreter", 3, 1, 1, "English", "C#", "A Befunge-93 Interpreter compatible with Befunge-98 dimensions.", "2013-05-03", "direkt", "", "", "", 0, "", -1);
	Do(30, "Serpilicum", "Serpilicum", 846, "Game", 3, 1, 1, "English", "C++", "A crazy little Snake with an \"Console\" Style", "2013-07-08", "direkt", "", "", "https://github.com/Mikescher/Serpilicum", 0, "", -1);
	Do(32, "SuperBitBros", "SuperBitBros", 870, "Game", 4, 1, 1, "English", "C#", "A clone of all original SuperMarioBros (NES) levels, with a few tweaks.", "2013-10-17", "direkt", "", "", "https://github.com/Mikescher/SuperBitBros", 0, "", -1);
	Do(35, "ExtendedGitGraph", "ExtendedGitGraph", 514, "Library", 2, 1, 1, "English", "PHP", "A simple php module to display a overview of you github commits", "2014-06-08", "https://github.com/Mikescher/extendedGitGraph/", "", "", "", 0, "", -1);
	Do(36, "SharkSim", "SharkSim", 428, "Simulation", 3, 1, 1, "English", "C++", "A simple implementation of the Wa-Tor cellular automaton", "2013-07-12", "", "", "", "", 0, "", -1);
	Do(37, "jQCCounter", "jQCCounter", 457, "Tool", 3, 1, 1, "English", "Java", "A little tool to find the \"line of codes\" of multiple projects", "2014-04-27", "", "", "", "https://github.com/Mikescher/jQCCounter", 0, "", -1);
	Do(38, "BefunUtils", "BefunUtils", 764, "Compiler", 4, 1, 1, "English", "C#", "My selfmade Code-to-Befunge93 compiler, with a few little extras.", "2014-08-04", "", "", "", "https://github.com/Mikescher/BefunUtils", 0, "", -1);
	Do(39, "HexSolver", "HexSolver", 423, "Tool", 5, 1, 1, "English", "C#", "An automatic parser and solver for Hexcells, Hexcells Plus and Hexcells Infinite.", "2015-05-06", "", "", "", "https://github.com/Mikescher/HexSolver", 0, "", -1);
	Do(40, "Passpad", "Passpad", 363, "Tool", 3, 1, 1, "English", "C#", "A texteditor for encrypted textfiles (AES, Twofish, Blowfish, ...)", "2015-11-26", "https://github.com/Mikescher/Passpad/releases", "", "", "https://github.com/Mikescher/Passpad", 0, "", -1);

}

void Do(int ID, string Name, string Thumbnailname, int Downloads, string Kategorie, int Sterne, int enabled, int visible, 
        string Language, string programming_lang, string Description, string add_date, 
		string download_url, string sourceforge_url, string homepage_url, string github_url, 
		int uses_absCanv, string update_identifier, int highscore_gid)
{
	StringBuilder b = new StringBuilder();

	b.AppendLine($"<?php");
	b.AppendLine($"");
	b.AppendLine($"return ");
	b.AppendLine($"[");
	b.AppendLine($"\t'name'              => '{Name}',");
	b.AppendLine($"\t'category'          => '{Kategorie}',");
	b.AppendLine($"\t'stars'             => {Sterne},");
	b.AppendLine($"\t'ui_language'       => '{Language}',");
	b.AppendLine($"\t'prog_language'     => '{programming_lang}',");
	b.AppendLine($"\t'short_description' => '{ToLiteral(Description)}',");
	b.AppendLine($"\t'add_date'          => '{add_date}',");
	b.AppendLine($"\t'urls'              =>");
	b.AppendLine($"\t[");
	if (!string.IsNullOrWhiteSpace(download_url))    b.AppendLine($"\t\t'download'    => '{ToLiteral(download_url)}',");
	if (!string.IsNullOrWhiteSpace(sourceforge_url)) b.AppendLine($"\t\t'sourceforge' => '{ToLiteral(sourceforge_url)}',");
	if (!string.IsNullOrWhiteSpace(homepage_url))    b.AppendLine($"\t\t'homepage'    => '{ToLiteral(homepage_url)}',");
	if (!string.IsNullOrWhiteSpace(github_url)) b.AppendLine($"\t\t'github'      => '{ToLiteral(github_url)}',");
	b.AppendLine($"\t],");
	b.AppendLine($"\t'long_description'  => function(){{ return file_get_contents(__DIR__ . '/{Name}_description.md'); }},");
	b.AppendLine($"\t'thumbnail_name'    => '/images/program_thumbnails/{Name}.png',");
	b.AppendLine($"];");

	File.WriteAllText(@"C:\Users\schwoerm\Desktop\M\hp\v4\www\rawdata\programs\" + $"{Name}.php", b.ToString(), ENC);
	File.WriteAllText(@"C:\Users\schwoerm\Desktop\M\hp\v4\www\rawdata\programs\" + $"{Name}_description.md", File.ReadAllText(@"C:\Users\schwoerm\Desktop\M\hp\v3\www\data\programs\desc\" + Name + @"\index.markdown"), ENC);
}

private static string ToLiteral(string input)
{
	using (var writer = new StringWriter())
	{
		using (var provider = CodeDomProvider.CreateProvider("CSharp"))
		{
			provider.GenerateCodeFromExpression(new CodePrimitiveExpression(input), writer, null);
			var a = writer.ToString();
			return a.Substring(1, a.Length-2);
		}
	}
}