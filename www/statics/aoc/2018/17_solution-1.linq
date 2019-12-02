<Query Kind="Program">
  <Namespace>System.Drawing</Namespace>
</Query>

bool[,] Map;
int X0;
int Y0;
int Width;
int Height;

enum Water { None=0, Flow=1, Rest=2 }
Water[,] water;

void Main()
{
	Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"17_input.txt")));
	//DumpMap();

	water[500, 0] = Water.Flow;
	int w = 0;
	Water[,] wold = new Water[Width, Height];
	for (int gen = 0; ; gen++)
	{
		Tick();
		//Util.ClearResults();
		//DumpMap();
		int w0 = WaterCount();
		if (w == w0 && WaterEquals(wold,water)) { $"{w0} after {gen} generations".Dump(); DumpMap(); /* DumpMapASCII(); */ return; }
		w=w0;
		for (int y = 0; y < Height; y++) for (int x = 0; x < Width; x++) wold[x,y]=water[x,y];
	}
	
	
}

bool WaterEquals(Water[,] a, Water[,] b)
{
	for (int y = 0; y < Height; y++) for (int x = 0; x < Width; x++) if (a[x,y] != b[x,y])return false;
	return true;
}

int WaterCount()
{
	int c = 0;
	for (int y = Y0; y < Height; y++) for (int x = 0; x < Width; x++) if (water[x,y] != Water.None)c++;
	return c;
}

void Tick()
{
	for (int xx = 0; xx < Width; xx++) for (int yy = 0; yy < Height; yy++) if (water[xx,yy]==Water.Flow) water[xx,yy]=Water.None;
	
	var next = new Stack<(int,int)>();
	next.Push( (500, 0) );
	while (next.Any())
	{
		(var x, var y) = next.Pop();
		
		if (y==Height-1) continue;
		
		if (Map[x,y+1] || water[x,y+1]==Water.Rest)
		{
			var l = false;
			var r = false;
			if (!Map[x - 1, y] && water[x - 1, y] == Water.None) { l = true; water[x - 1, y] = Water.Flow; next.Push((x - 1, y)); }
			if (!Map[x + 1, y] && water[x + 1, y] == Water.None) { r = true; water[x + 1, y] = Water.Flow; next.Push((x + 1, y)); }

			if (!l && !r)
			{
				var solid = true;
				for (int xx = x; solid; xx++)
				{
					if (water[xx, y] == Water.None) { solid = false; break; }
					if (!(Map[xx, y + 1] || water[xx, y + 1] == Water.Rest)) { solid = false; break; }
					if (Map[xx + 1, y]) break;
				}
				for (int xx = x; solid; xx--)
				{
					if (water[xx, y] == Water.None) { solid = false; break; }
					if (!(Map[xx, y + 1] || water[xx, y + 1] == Water.Rest)) { solid = false; break; }
					if (Map[xx - 1, y]) break;
				}

				if (solid)
				{
					for (int xx = x; !Map[xx, y]; xx++) { Assert(water[xx, y] != Water.None); water[xx, y] = Water.Rest; }
					for (int xx = x; !Map[xx, y]; xx--) { Assert(water[xx, y] != Water.None); water[xx, y] = Water.Rest; }
				}
			}
		}
		else
		{
			water[x, y+1] = Water.Flow;
			next.Push( (x,y+1) );
		}
	}
}

void Load(string[] v)
{
	var data = new List<(int,int,int,int)>();
	
	for (int i = 0; i < v.Length; i++)
	{
		var a = v[i].Split(',')[0].Trim();
		var b = v[i].Split(',')[1].Trim();

		if (b.StartsWith("x")) { var t = b; b = a; a = t; }

		a = a.Substring(2);
		b = b.Substring(2);

		var a1 = int.Parse(a.Contains("..") ? a.Split('.')[0] : a);
		var a2 = int.Parse(a.Contains("..") ? a.Split('.')[2] : a);
		var b1 = int.Parse(b.Contains("..") ? b.Split('.')[0] : b);
		var b2 = int.Parse(b.Contains("..") ? b.Split('.')[2] : b);
		
		data.Add( (a1,a2,b1,b2) );
	}

	Width  = data.Max(m => Math.Max(m.Item1, m.Item2)) + 1;
	Height = data.Max(m => Math.Max(m.Item3, m.Item4)) + 1;
	X0     = data.Min(m => Math.Min(m.Item1, m.Item2)) - 1;
	Y0     = data.Min(m => Math.Min(m.Item3, m.Item4));
	Map = new bool[Width, Height];

	foreach ((var x1, var x2, var y1, var y2) in data)
	{
		for (int x = x1; x <= x2; x++) for (int y = y1; y <= y2; y++) Map[x, y] = true;
	}

	water = new Water[Width, Height];
}

void DumpMap()
{
	Bitmap bmp = new Bitmap(Width - X0, Height, System.Drawing.Imaging.PixelFormat.Format24bppRgb);
	using (Graphics g = Graphics.FromImage(bmp))
	{
		g.Clear(Color.Wheat);
		for (int y = 0; y < Height; y++)
		{
			for (int x = X0; x < Width; x++)
			{
				if (x == (500 - X0) && y == 0) g.FillRectangle(Brushes.DarkBlue, x - X0, y, 1, 1);
				else if (Map[x, y]) g.FillRectangle(Brushes.Black, x - X0, y, 1, 1);
				else if (water[x, y] == Water.Flow) g.FillRectangle(Brushes.Cyan, x - X0, y, 1, 1);
				else if (water[x, y] == Water.Rest) g.FillRectangle(Brushes.LightBlue, x - X0, y, 1, 1);
			}
		}
	}
	bmp.Dump();
}

void DumpMapASCII()
{
	StringBuilder b = new StringBuilder();
	for (int y = 0; y < Height; y++)
	{
		for (int x = 0; x < Width; x++)
		{
			if (x == (500) && y == 0) b.Append('+');
			else if (Map[x, y]) b.Append('#');
			else if (water[x, y] == Water.Flow) b.Append('|');
			else if (water[x, y] == Water.Rest) b.Append('~');
			else b.Append('.');
		}
		b.AppendLine();
	}
	b.ToString().Dump();
}

void Assert(bool b) { if (!b) throw new Exception(); }