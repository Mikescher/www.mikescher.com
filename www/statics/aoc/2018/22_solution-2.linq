<Query Kind="Program" />

void Main()
{
	const int expand = 2;

	const int T_ROCKY   = 0;
	const int T_WET     = 1;
	const int T_NARROW  = 2;
	const int G_NEITHER = 0;
	const int G_TORCH   = 1;
	const int G_GEAR    = 2;

	var input  = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"22_input.txt"));
	
	var depth               = long.Parse(input[0].Split(' ')[1]);
	(long x, long y) target = (long.Parse(input[1].Split(' ')[1].Split(',')[0]), long.Parse(input[1].Split(' ')[1].Split(',')[1]));

	var width  = target.x * expand + 1;
	var height = target.y * expand + 1;

	long[,] map = new long[width, height]; // erosion_level

	for (long xx = 0; xx < width;  xx++) map[xx, 0] = ((xx * 16807) + depth) % 20183;
	for (long yy = 0; yy < height; yy++) map[0, yy] = ((yy * 48271) + depth) % 20183;

	for (long x = 1; x < width; x++)
	{
		for (long y = 1; y < height; y++)
		{
			map[x, y] = ((map[x-1, y] * map[x, y-1]) + depth) % 20183;
		}
	}

	int[,] typemap = new int[width, height];

	for (long x = 0; x < width; x++) for (long y = 0; y < height; y++) typemap[x,y] = (int)(map[x,y] % 3);
	typemap[target.x, target.y] = 0;

	bool[,] validity = new bool[3, 3];
	validity[T_ROCKY,  G_NEITHER] = false;
	validity[T_ROCKY,  G_TORCH]   = true;
	validity[T_ROCKY,  G_GEAR]    = true;
	validity[T_WET,    G_NEITHER] = true;
	validity[T_WET,    G_TORCH]   = false;
	validity[T_WET,    G_GEAR]    = true;
	validity[T_NARROW, G_NEITHER] = true;
	validity[T_NARROW, G_TORCH]   = true;
	validity[T_NARROW, G_GEAR]    = false;


	int?[,,] distance = new int?[width, height, 3];
	distance[0,0,1] = 0;
	
	var work = new Queue<(int, int, int)>();
	work.Enqueue((0,0,1));
	while (work.Any())
	{
		(var px, var py, var pt) = work.Dequeue();
		var dist = distance[px,py,pt];
		
		//LEFT
		if (px>0 && validity[typemap[px-1,py], pt] && (distance[px-1,py,pt]==null || distance[px-1,py,pt]>dist+1)) { distance[px-1,py,pt]=dist+1; if (!work.Contains((px-1,py,pt))) work.Enqueue((px-1,py,pt)); }
		
		//UP
		if (py>0 && validity[typemap[px,py-1], pt] && (distance[px,py-1,pt]==null || distance[px,py-1,pt]>dist+1)) { distance[px,py-1,pt]=dist+1; if (!work.Contains((px,py-1,pt))) work.Enqueue((px,py-1,pt)); }
		
		//RIGHT
		if (px+1<width && validity[typemap[px+1,py], pt] && (distance[px+1,py,pt]==null || distance[px+1,py,pt]>dist+1)) { distance[px+1,py,pt]=dist+1; if (!work.Contains((px+1,py,pt))) work.Enqueue((px+1,py,pt)); }
		
		//DOWN
		if (py+1<height && validity[typemap[px,py+1], pt] && (distance[px,py+1,pt]==null || distance[px,py+1,pt]>dist+1)) { distance[px,py+1,pt]=dist+1; if (!work.Contains((px,py+1,pt))) work.Enqueue((px,py+1,pt)); }
		
		//NEITHER
		if (pt != G_NEITHER && validity[typemap[px,py], G_NEITHER] &&  (distance[px,py,G_NEITHER]==null || distance[px,py,G_NEITHER]>dist+7)) { distance[px,py,G_NEITHER]=dist+7; if (!work.Contains((px,py,G_NEITHER))) work.Enqueue((px,py,G_NEITHER)); }
		
		//TORCH
		if (pt != G_TORCH && validity[typemap[px,py], G_TORCH] &&  (distance[px,py,G_TORCH]==null || distance[px,py,G_TORCH]>dist+7)) { distance[px,py,G_TORCH]=dist+7; if (!work.Contains((px,py,G_TORCH))) work.Enqueue((px,py,G_TORCH)); }
		
		//GEAR
		if (pt != G_GEAR && validity[typemap[px,py], G_GEAR] &&  (distance[px,py,G_GEAR]==null || distance[px,py,G_GEAR]>dist+7)) { distance[px,py,G_GEAR]=dist+7; if (!work.Contains((px,py,G_GEAR))) work.Enqueue((px,py,G_GEAR)); }
	}	
	
	distance[target.x, target.y, G_TORCH].Dump();

}

// Define other methods and classes here