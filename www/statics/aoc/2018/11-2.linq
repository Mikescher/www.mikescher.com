<Query Kind="Statements" />

int serial_num = int.Parse(File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"11_input.txt")));


int[,] scache = new int[301, 301];
for (int x = 1; x <= 300; x++) for (int y = 1; y <= 300; y++) scache[x, y] = (((x + 10) * ((x + 10) * y + serial_num) / 100) % 10) - 5;

int[,] cache = new int[301, 301];
for (int x = 1; x <= 300; x++) for (int y = 1; y <= 300; y++) cache[x, y] = 0;

var max = (pow:0, x:0,y:0,s:0);

for (int s = 1; s <= 300; s++)
{
	for (int x = 1; x <= 1+ 300-s; x++)
	{
		for (int y = 1; y <= 1 + 300 - s; y++)
		{

			var v = cache[x, y];
			for (int ix = 0; ix < s; ix++)   v += scache[x + ix, y + s - 1];
			for (int iy = 0; iy < s-1; iy++) v += scache[x + s - 1, y + iy];
			
			cache[x,y]=v;
			
			if (v > max.pow) max = (v,x,y,s);
		}
	}
	
	Util.Progress = (s*100)/300;
}

$"{max.x},{max.y},{max.s}".Dump();