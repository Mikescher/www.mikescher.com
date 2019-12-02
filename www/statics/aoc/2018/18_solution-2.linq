<Query Kind="Program" />

enum Field { Empty, Tree, Lumber }

Dictionary<char, Field> mapping = new Dictionary<char, Field>
{
	{'.', Field.Empty},
	{'|', Field.Tree},
	{'#', Field.Lumber},
};

int Width;
int Height;
Field[,] Map;

void Main()
{
	Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"18_input.txt")));
	//$"Initial state:".Dump();Dump();
	
	var history = new Dictionary<string, int>();
	
	int gen=0;
	for (;;)
	{
		Tick();
		gen++;
		
		var hash = Hash();
		
		if (history.ContainsKey(hash))
		{
			int loop = gen-history[hash];
			
			int remaining = 1000000000;
			remaining -= gen;
			
			var off = remaining % loop;

			for (int i = 0; i < off; i++) { Tick(); gen++; }

			$"After {gen} ticks there are {FullCount(Field.Tree)} trees and {FullCount(Field.Lumber)} lumbers, the score is {FullCount(Field.Tree) * FullCount(Field.Lumber)} and the state loops every {loop} generations".Dump();

			return;
		}
		else
		{
			history[hash] = gen;
		}
	}

}

string Hash()
{
	StringBuilder b = new StringBuilder();
	for (int y = 0; y < Height; y++) for (int x = 0; x < Width; x++) b.Append((char)('0'+(int)Map[x, y]));
	return b.ToString();
}

void Dump()
{
	StringBuilder b = new StringBuilder();
	for (int y = 0; y < Height; y++)
	{
		for (int x = 0; x < Width; x++)
		{
			if (Map[x, y] == Field.Empty) b.Append('.');
			else if (Map[x, y] == Field.Tree) b.Append('|');
			else if (Map[x, y] == Field.Lumber) b.Append('#');
			else throw new Exception(".");
		}
		b.AppendLine();
	}
	b.ToString().Dump();
	"".Dump();
}

void Load(string[] input)
{
	Width = input[0].Length;
	Height = input.Length;
	Map = new Field[Width, Height];
	for (var x = 0; x < Width; x++) for (var y = 0; y < Height; y++) Map[x, y] = mapping[input[y][x]];
}

void Tick()
{
	var d = new Field[Width,Height];
	for (var y = 0; y < Height; y++) for (var x = 0; x < Width; x++) Tick(ref Map, ref d, x, y);
	Map=d;
}

void Tick(ref Field[,] src, ref Field[,] dst, int x, int y)
{
	if (src[x,y] == Field.Empty)
	{
		dst[x,y] = (Count(ref src, x, y, Field.Tree) >= 3) ? Field.Tree : Field.Empty;
	}
	else if (src[x, y] == Field.Tree)
	{
		dst[x, y] = (Count(ref src, x, y, Field.Lumber) >= 3) ? Field.Lumber : Field.Tree;
	}
	else if (src[x, y] == Field.Lumber)
	{
		dst[x, y] = (Count(ref src, x, y, Field.Lumber) >= 1 && Count(ref src, x, y, Field.Tree) >= 1) ? Field.Lumber : Field.Empty;
	}
}

int Count(ref Field[,] fld, int x, int y, Field s)
{
	int c = 0;
	if (x > 0       && y > 0        && fld[x - 1, y - 1] == s) c++; 
	if (x > 0                       && fld[x - 1, y    ] == s) c++;
	if (x > 0       && y < Height-1 && fld[x - 1, y + 1] == s) c++;
	if (               y < Height-1 && fld[x    , y + 1] == s) c++;
	if (x < Width-1 && y < Height-1 && fld[x + 1, y + 1] == s) c++;
	if (x < Width-1                 && fld[x + 1, y    ] == s) c++;
	if (x < Width-1 && y > 0        && fld[x + 1, y - 1] == s) c++;
	if (               y > 0        && fld[x    , y - 1] == s) c++;
	return c;
}

int FullCount(Field f)
{
	int c = 0;
	for (var x = 0; x < Width; x++) for (var y = 0; y < Height; y++) if (Map[x,y]==f)c++;
	return c;
}