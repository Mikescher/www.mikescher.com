<Query Kind="Program">
  <Namespace>System.Drawing</Namespace>
</Query>

class Step { public int X,Y; public char Dir; public int P; public List<Step> NextSteps = new List<Step>(); }

int StartX;
int StartY;
int Width;
int Height;
bool[,] Doors;
bool[,] Reachable;
int?[,] Distance;
Step RootStep;

void Main()
{
	Load(File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"20_input.txt")).Trim());
	//DumpSteps();
	//int c=0; VerifySteps(RootStep, ref c);c.Dump();
	Walk();
	Flood().Dump();
	DumpMap();
}

void VerifySteps(Step s, ref int c)
{
	for(;;)
	{
		c++;
		if (s.NextSteps.Any(ns => ns.P>=s.P)) throw new Exception();
		if (s.NextSteps.Count == 1) { s = s.NextSteps.Single(); continue; }

		foreach (var ns in s.NextSteps) VerifySteps(ns, ref c);
		return;
	}
}

void DumpSteps()
{
	StringBuilder b = new StringBuilder();
	DumpSteps(RootStep, ref b, 0);
}

void DumpSteps(Step s, ref StringBuilder b, int w)
{
	int sscc = 0;
	for (; ; )
	{
		if (s.NextSteps.Count == 0) { b.Append(sscc.ToString()); w += sscc.ToString().Length; break; }
		if (s.NextSteps.Count == 1) { sscc++; s = s.NextSteps.Single(); continue; }

		{b.Append(sscc.ToString()); w += sscc.ToString().Length;}
		int l = w;
		foreach (var ns in s.NextSteps)
		{
			b.ToString().Dump();b.Clear();
			b.Append(new string(' ', l));
			DumpSteps(ns, ref b, w);
		}
		return;
	}
}

void Load(string d)
{
	d = d.Substring(1, d.Length - 2);

	StartX    = d.Count(c => c == 'W') + 16;
	StartY    = d.Count(c => c == 'N') + 16;
	Width     = d.Count(c => c == 'E') + 16 + StartX;
	Height    = d.Count(c => c == 'S') + 16 + StartY;
	Doors     = new bool[Width * 2 + 16, Height + 16];
	Distance  = new int?[Width, Height];
	Reachable = new bool[Width, Height];

	RootStep = Parse(d);
}

Step Parse(string d)
{
	Step r = null;
	Parse(new List<Step>(), ref d, ref r);
	if (d!="")throw new Exception();
	return r;
}

List<Step> Parse(List<Step> source, ref string d, ref Step root)
{
	List<Step> lasts = source;
	for (; ; )
	{
		if (d    == "") return lasts;
		if (d[0] == '|') return lasts;
		if (d[0] == ')') return lasts;
		if (d[0] == '(')
		{
			d = d.Substring(1);
			List<Step> newlasts = new List<Step>();
			for (;;)
			{
				if (d[0] == ')') { d = d.Substring(1); newlasts.AddRange(lasts); break; }
				
				var n = Parse(lasts, ref d, ref root);
				newlasts.AddRange(n);

				if (d[0] == '|') { d = d.Substring(1); continue; }
				if (d[0] == ')') { d = d.Substring(1); break;    }
				
				throw new Exception();
			}
			lasts = newlasts;
			continue;
		}

		if (d[0] == 'N') { var s = new Step { X = 00, Y = -1, Dir=d[0], P=d.Length, }; lasts.ForEach(l => l.NextSteps.Add(s)); lasts = new List<Step> {s}; d = d.Substring(1); root = root ?? s; continue; }
		if (d[0] == 'E') { var s = new Step { X = +1, Y = 00, Dir=d[0], P=d.Length, }; lasts.ForEach(l => l.NextSteps.Add(s)); lasts = new List<Step> {s}; d = d.Substring(1); root = root ?? s; continue; }
		if (d[0] == 'S') { var s = new Step { X = 00, Y = +1, Dir=d[0], P=d.Length, }; lasts.ForEach(l => l.NextSteps.Add(s)); lasts = new List<Step> {s}; d = d.Substring(1); root = root ?? s; continue; }
		if (d[0] == 'W') { var s = new Step { X = -1, Y = 00, Dir=d[0], P=d.Length, }; lasts.ForEach(l => l.NextSteps.Add(s)); lasts = new List<Step> {s}; d = d.Substring(1); root = root ?? s; continue; }

		throw new Exception();
	}
}

void Walk()
{
	Stack<(int x,int y, Step s)> work = new Stack<(int x, int y, Step s)>();
	work.Push((StartX, StartY, RootStep));
	
	while(work.Any())
	{
		(var x, var y, var step) = work.Pop();
		Reachable[x,y]=true;
		
		if (step.Dir == 'N') Doors[x*2, y]  = true;
		if (step.Dir == 'E') Doors[x*2+1,y] = true;
		if (step.Dir == 'S') Doors[x*2,y+1] = true;
		if (step.Dir == 'W') Doors[x*2-1,y] = true;

		x += step.X;
		y += step.Y;
		foreach (var ns in step.NextSteps) work.Push((x,y,ns));
		//DumpMap();
	}

}

int Flood()
{
	Stack<(int x, int y)> work = new Stack<(int x, int y)>();
	work.Push((StartX, StartY));
	Distance[StartX, StartY]=0;

	while (work.Any())
	{
		(var x, var y) = work.Pop();

		if (Doors[x * 2,     y    ] && (Distance[x+0,y-1] == null || Distance[x+0,y-1].Value > Distance[x,y]+1)) { Distance[x+0,y-1] = Distance[x,y]+1; work.Push((x+0,y-1)); }
		if (Doors[x * 2 + 1, y    ] && (Distance[x+1,y+0] == null || Distance[x+1,y+0].Value > Distance[x,y]+1)) { Distance[x+1,y+0] = Distance[x,y]+1; work.Push((x+1,y+0)); }
		if (Doors[x * 2,     y + 1] && (Distance[x+0,y+1] == null || Distance[x+0,y+1].Value > Distance[x,y]+1)) { Distance[x+0,y+1] = Distance[x,y]+1; work.Push((x+0,y+1)); }
		if (Doors[x * 2 - 1, y    ] && (Distance[x-1,y+0] == null || Distance[x-1,y+0].Value > Distance[x,y]+1)) { Distance[x-1,y+0] = Distance[x,y]+1; work.Push((x-1,y+0)); }
	}
	
	int max = int.MinValue;
	for (int xx = 0; xx < Width; xx++) for (int yy = 0; yy < Height; yy++) max = Math.Max(Distance[xx,yy] ?? max, max);
	return max;
}

void DumpMap()
{
	var ww = Width * 2 + 1;
	var hh = Height * 2 + 1;
	char[,] m = new char[Width * 2 + 1, Height * 2 + 1];

	int _sx = 0;
	int _ex = 0;
	int _sy = 0;
	int _ey = 0;
	for (int xx = 0; ; xx++)
	{
		var ff = false;
		for (int yy = 0; yy < Height; yy++) if (Reachable[xx, yy]) ff = true;
		if (ff) { _sx = xx; break; }
	}
	for (int xx = Width - 1; ; xx--)
	{
		var ff = false;
		for (int yy = 0; yy < Height; yy++) if (Reachable[xx, yy]) ff = true;
		if (ff) { _ex = xx; break; }
	}
	for (int yy = 0; ; yy++)
	{
		var ff = false;
		for (int xx = 0; xx < Width; xx++) if (Reachable[xx, yy]) ff = true;
		if (ff) { _sy = yy; break; }
	}
	for (int yy = Height - 1; ; yy--)
	{
		var ff = false;
		for (int xx = 0; xx < Width; xx++) if (Reachable[xx, yy]) ff = true;
		if (ff) { _ey = yy; break; }
	}

	var sy = _sy * 2 + 1 - 1;
	var sx = _sx * 2 + 1 - 1;
	var ey = _ey * 2 + 1 + 2;
	var ex = _ex * 2 + 1 + 2;
	

	for (int xx = sx; xx <= ex; xx++) for (int yy = sy; yy <= ey; yy++) m[xx, yy] = '?';

	for (int xx = sx; xx <= ex; xx += 2) for (int yy = sy; yy <= ey; yy++) m[xx, yy] = '#';
	for (int yy = sy; yy <= ey; yy += 2) for (int xx = sx; xx <= ex; xx++) m[xx, yy] = '#';
	
	for (int ix = _sx; ix <= _ex; ix++)
	{
		for (int iy = _sy; iy <= _ey; iy++)
		{
			if (Doors[ix * 2,     iy    ]) { m[ix*2+1, iy*2+1-1]='-'; }
			if (Doors[ix * 2 + 1, iy    ]) { m[ix*2+1+1, iy*2+1]='|'; }
			if (Doors[ix * 2,     iy + 1]) { m[ix*2+1, iy*2+1+1]='-'; }
			if (Doors[ix * 2 - 1, iy    ]) { m[ix*2+1-1, iy*2+1]='|'; }
			
			if (Distance[ix,iy]!= null) { m[ix*2+1, iy*2+1]='.'; }
		}
	}
	

	m[StartX * 2 + 1, StartY * 2 + 1] = 'X';

	int f = 6;
	Bitmap bmp = new Bitmap(((ex-sx)+(ex-sx)/2) * f, ((ey-sy)+(ey-sy)/2) * f, System.Drawing.Imaging.PixelFormat.Format24bppRgb);
	using (Graphics g = Graphics.FromImage(bmp))
	{
		g.Clear(Color.Magenta);
		for (int yy = sy; yy < ey; yy++)
		{
			for (int xx = sx; xx < ex; xx++)
			{
				int rx = (xx - sx) + (xx - sx) / 2;
				int ry = (yy - sy) + (yy - sy) / 2;
				int rw = ((xx - sx) % 2) + 1;
				int rh = ((yy - sy) % 2) + 1;

				var c = Brushes.Magenta;
				if (m[xx, yy] == '#') c = Brushes.Black;
				if (m[xx, yy] == 'X') c = Brushes.Green;
				if (m[xx, yy] == '.') c = Brushes.White;
				if (m[xx, yy] == '?') c = Brushes.DarkGray;
				if (m[xx, yy] == '|') c = Brushes.LightGray;
				if (m[xx, yy] == '-') c = Brushes.LightGray;
				g.FillRectangle(c, rx*f, ry*f, rw*f, rh*f);
			}
		}
	}
	bmp.Dump();

	//StringBuilder b = new StringBuilder();
	//for (int yy = 0; yy < hh; yy++)
	//{
	//	for (int xx = 0; xx < ww; xx++)
	//	{
	//		b.Append(m[xx,yy]);
	//	}
	//	b.AppendLine();
	//}
	//b.ToString().Dump();
}