<Query Kind="Program" />

class Rail
{
    public int X,Y;
    public Rail N,E,S,W;
}
class Cart
{
    public Dir D;
    public Rail R;
	public int Mem=0;
}
enum Dir {N=0,E=1,S=2,W=3}

void Main()
{
	(List<Rail> rails, List<Cart> carts) = Parse(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"13_input.txt")));

	for (int gen=0;;gen++)
    {
        foreach	(var c in carts.OrderBy(c => c.R.Y*10000+c.R.X))
		{
			switch (c.D)
			{
				case Dir.S:
					Move(c, new[] { (Dir.E, c.R.E), (Dir.S, c.R.S), (Dir.W, c.R.W) });
					break;
				case Dir.W:
					Move(c, new[] { (Dir.S, c.R.S), (Dir.W, c.R.W), (Dir.N, c.R.N) });
					break;
				case Dir.N:
					Move(c, new[] { (Dir.W, c.R.W), (Dir.N, c.R.N), (Dir.E, c.R.E) });
					break;
				case Dir.E:
					Move(c, new[] { (Dir.N, c.R.N), (Dir.E, c.R.E),  (Dir.S, c.R.S) });
					break;
			}

			if (carts.Any(oc => oc != c && oc.R == c.R)) { $"{c.R.X},{c.R.Y} after {gen}".Dump(); return; }

		}
		//foreach (var c in carts) $"{c.R.X}|{c.R.Y}|{c.D}".Dump();"------".Dump();
	}
    
}

void Move(Cart c, IEnumerable<(Dir, Rail)> options)
{
	var outs = options.Where(p => p.Item2 != null).ToList();
	if (outs.Count == 1)
	{
		c.R = outs[0].Item2;
		c.D = outs[0].Item1;
	}
	else
	{
		c.R = outs[c.Mem % 3].Item2;
		c.D = outs[c.Mem % 3].Item1;
		c.Mem++;
	}

}

void Dump(List<Rail> rails, List<Cart> carts)
{
	int maxx = rails.Max(r => r.X) + 1;
	int maxy = rails.Max(r => r.Y) + 1;

	var b = new StringBuilder();
	for (int yy = 0; yy < maxy; yy++)
	{
		for (int xx = 0; xx < maxx; xx++)
		{
			var cc = carts.FirstOrDefault(c => c.R.X == xx && c.R.Y == yy);
			if (cc != null)
			{
				if (cc.D == Dir.N) b.Append('^');
				if (cc.D == Dir.E) b.Append('>');
				if (cc.D == Dir.S) b.Append('v');
				if (cc.D == Dir.W) b.Append('<');
			}
			else if (rails.Any(r => r.X == xx && r.Y == yy))
			{
				b.Append('.');
			}
			else
			{
				b.Append(' ');
			}
		}
		b.AppendLine();
	}
	b.ToString().Dump();
	"".Dump();
}

(List<Rail>, List<Cart>) Parse(string[] line)
{
    var rails = new Dictionary<(int,int), Rail>();
    var carts = new List<Cart>();

    Rail get(int x, int y) { if(rails.TryGetValue((x,y), out var v))return v; Rail r = new Rail { X = x, Y = y }; rails.Add((x,y),r); return r; }
    
    char last = ' ';
    for (int y = 0; y < line.Length; y++)
    {
        last = ' ';
        for (int x = 0; x < line[y].Length; x++)
        {
            char c = line[y][x];
            if (c==' ') continue;
            
            switch (c)
            {
                case '-':
                    {
                        var rr = get(x, y);
                        var ra = get(x - 1, y);
                        var rb = get(x + 1, y);
                        rr.W = ra; ra.E = rr;
                        rr.E = rb; rb.W = rr;
                    }
                    break;
                case '|':
                    {
                        var rr = get(x, y);
                        var ra = get(x, y - 1);
                        var rb = get(x, y + 1);
                        rr.N = ra; ra.S = rr;
                        rr.S = rb; rb.N = rr;
                    }
                    break;
                case '+':
                    {
                        var rr = get(x, y);
                        var ra = get(x, y - 1);
                        var rb = get(x + 1, y);
                        var rc = get(x, y + 1);
                        var rd = get(x - 1, y);
                        rr.N = ra; ra.S = rr;
                        rr.E = rb; rb.W = rr;
                        rr.S = rc; rc.N = rr;
                        rr.W = rd; rd.E = rr;
                    }
                    break;
                case '/':
                    if (last == '-' || last == '+')
                    {
                        var rr = get(x, y);
                        var ra = get(x - 1, y);
                        var rb = get(x, y - 1);
                        rr.W = ra; ra.E = rr;
                        rr.N = rb; rb.S = rr;
                    }
                    else
                    {
                        var rr = get(x, y);
                        var ra = get(x + 1, y);
                        var rb = get(x, y + 1);
                        rr.E = ra; ra.W = rr;
                        rr.S = rb; rb.N = rr;
                    }
                    break;
                case '\\':
                    if (last == '-' || last == '+')
                    {
                        var rr = get(x, y);
                        var ra = get(x - 1, y);
                        var rb = get(x, y + 1);
                        rr.W = ra; ra.E = rr;
                        rr.S = rb; rb.N = rr;
                    }
                    else
                    {
                        var rr = get(x, y);
                        var ra = get(x + 1, y);
                        var rb = get(x, y - 1);
                        rr.E = ra; ra.W = rr;
                        rr.N = rb; rb.S = rr;
                    }
                    break;
                case '^':
                    {
                        var rr = get(x, y);
                        var ra = get(x, y - 1);
                        var rb = get(x, y + 1);
                        rr.N = ra; ra.S = rr;
                        rr.S = rb; rb.N = rr;
                        carts.Add(new Cart { D = Dir.N, R=rr, });
                    }
                    break;
                case 'v':
                    {
                        var rr = get(x, y);
                        var ra = get(x, y - 1);
                        var rb = get(x, y + 1);
                        rr.N = ra; ra.S = rr;
                        rr.S = rb; rb.N = rr;
                        carts.Add(new Cart { D = Dir.S, R=rr, });
                    }
                    break;
                case '>':
                    {
                        var rr = get(x, y);
                        var ra = get(x - 1, y);
                        var rb = get(x + 1, y);
                        rr.W = ra; ra.E = rr;
                        rr.E = rb; rb.W = rr;
                        carts.Add(new Cart { D = Dir.E, R = rr, });
                    }
                    break;
                case '<':
                    {
                        var rr = get(x, y);
                        var ra = get(x - 1, y);
                        var rb = get(x + 1, y);
                        rr.W = ra; ra.E = rr;
                        rr.E = rb; rb.W = rr;
                        carts.Add(new Cart { D = Dir.W, R = rr, });
                    }
                    break;
            }
            last = c;
        }
    }
    
    return (rails.Select(p=>p.Value).ToList(), carts);
}