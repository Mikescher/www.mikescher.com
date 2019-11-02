<Query Kind="Program" />

enum Fraction { Wall, Elf, Goblin }

class Entity
{
	public Fraction Frac;
	public int AttackPower;
	public int HitPoints;
	public int X, Y;
	public bool Alive;

	public override string ToString() => $"{Frac}[{AttackPower};{HitPoints}]";
}

int Width  = 0;
int Height = 0;
Entity[,] Map = null;
List<Entity> Units = null;

readonly bool DUMP_REACHABLE   = false;
readonly bool DUMP_PATHFINDING = false;
readonly bool DUMP_MAP         = false;

void Main()
{
	Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"15_input.txt")));

	for (int gen = 0; ; gen++)
	{
		if (DUMP_MAP) DumpMap(gen);
		
		//if (gen==60)Util.Break();
		foreach (var u in Units.OrderBy(p=>p.Y).ThenBy(p=>p.X).ToList())
		{
			if (!u.Alive) continue;
			var success = Tick(u);
			if (!success && (Units.Count(q => q.Frac == Fraction.Elf) == 0 || Units.Count(q => q.Frac == Fraction.Goblin) == 0))
			{
				if (DUMP_MAP) DumpMap(gen+1);
				
				var winner = Units.Where(q => q.Frac != Fraction.Wall).Select(p => p.Frac).Distinct().Single();
				var count = Units.Count(q => q.Frac != Fraction.Wall);
				var hpsum = Units.Where(q => q.Frac != Fraction.Wall).Sum(q => q.HitPoints);
				$"Finished after {gen} rounds with {count} Units ({winner}) and {hpsum} Total HP. The score is [ {hpsum * gen} ] ".Dump();
				return;
			}
		}
	}
}

bool Tick(Entity e)
{
	var enemyFraction = e.Frac==Fraction.Elf ? Fraction.Goblin : Fraction.Elf;
	
	// [1] Fast Attack
	{
		Entity target = null;
		if (e.Y > 0          && Map[e.X, e.Y - 1] != null && Map[e.X, e.Y - 1].Frac == enemyFraction && (target == null || Map[e.X, e.Y - 1].HitPoints < target.HitPoints)) target = Map[e.X, e.Y - 1];
		if (e.X > 0          && Map[e.X - 1, e.Y] != null && Map[e.X - 1, e.Y].Frac == enemyFraction && (target == null || Map[e.X - 1, e.Y].HitPoints < target.HitPoints)) target = Map[e.X - 1, e.Y];
		if (e.X < Width - 1  && Map[e.X + 1, e.Y] != null && Map[e.X + 1, e.Y].Frac == enemyFraction && (target == null || Map[e.X + 1, e.Y].HitPoints < target.HitPoints)) target = Map[e.X + 1, e.Y];
		if (e.Y < Height - 1 && Map[e.X, e.Y + 1] != null && Map[e.X, e.Y + 1].Frac == enemyFraction && (target == null || Map[e.X, e.Y + 1].HitPoints < target.HitPoints)) target = Map[e.X, e.Y + 1];
		
		if (target != null) { Attack(e,target); return true; }
	}

	// [2] Path Finding
	{
		var targetPos = ListTargets(enemyFraction)
			.Select(p => (p, GetDistance( (e.X, e.Y), (p.x, p.y) ) ) )
			.Where(p => p.Item2!=null)
			.OrderBy(p => p.Item2)
			.ThenBy(p=>p.p.y)
			.ThenBy(p=>p.p.x)
			.Select(p=>p.p)
			.FirstOrDefault();
		
		if (targetPos==default) { return false; }
		
		int[,] matrix = DoPathFinding(targetPos.x, targetPos.y);
		if (DUMP_PATHFINDING) DumpPathFinding(matrix, e, (targetPos.x, targetPos.y));

		Tuple<int, int, int> targetStep = null;
		if (e.Y > 0          && matrix[e.X, e.Y - 1] >= 0 && matrix[e.X, e.Y - 1] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X, e.Y - 1])) targetStep = Tuple.Create(e.X, e.Y - 1, matrix[e.X, e.Y - 1]);
		if (e.X > 0          && matrix[e.X - 1, e.Y] >= 0 && matrix[e.X - 1, e.Y] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X - 1, e.Y])) targetStep = Tuple.Create(e.X - 1, e.Y, matrix[e.X - 1, e.Y]);
		if (e.X < Width - 1  && matrix[e.X + 1, e.Y] >= 0 && matrix[e.X + 1, e.Y] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X + 1, e.Y])) targetStep = Tuple.Create(e.X + 1, e.Y, matrix[e.X + 1, e.Y]);
		if (e.Y < Height - 1 && matrix[e.X, e.Y + 1] >= 0 && matrix[e.X, e.Y + 1] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X, e.Y + 1])) targetStep = Tuple.Create(e.X, e.Y + 1, matrix[e.X, e.Y + 1]);

		//if (e.X > 0          && matrix[e.X - 1, e.Y] >= 0 && matrix[e.X - 1, e.Y] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X - 1, e.Y])) targetStep = Tuple.Create(e.X - 1, e.Y, matrix[e.X - 1, e.Y]);
		//if (e.Y > 0          && matrix[e.X, e.Y - 1] >= 0 && matrix[e.X, e.Y - 1] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X, e.Y - 1])) targetStep = Tuple.Create(e.X, e.Y - 1, matrix[e.X, e.Y - 1]);
		//if (e.Y < Height - 1 && matrix[e.X, e.Y + 1] >= 0 && matrix[e.X, e.Y + 1] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X, e.Y + 1])) targetStep = Tuple.Create(e.X, e.Y + 1, matrix[e.X, e.Y + 1]);
		//if (e.X < Width - 1  && matrix[e.X + 1, e.Y] >= 0 && matrix[e.X + 1, e.Y] < int.MaxValue && (targetStep == null || targetStep.Item3 > matrix[e.X + 1, e.Y])) targetStep = Tuple.Create(e.X + 1, e.Y, matrix[e.X + 1, e.Y]);
		
		if (targetStep == null) { return false; }
		Move(e, targetStep.Item1, targetStep.Item2);

		// [3] Normal Attack
		if (targetStep.Item3 == 0)
		{
			Entity att = null;
			if (e.Y > 0          && Map[e.X, e.Y - 1] != null && Map[e.X, e.Y - 1].Frac==enemyFraction && (att == null || att.HitPoints > Map[e.X, e.Y - 1].HitPoints)) att = Map[e.X, e.Y - 1];
			if (e.X > 0          && Map[e.X - 1, e.Y] != null && Map[e.X - 1, e.Y].Frac==enemyFraction && (att == null || att.HitPoints > Map[e.X - 1, e.Y].HitPoints)) att = Map[e.X - 1, e.Y];
			if (e.X < Width - 1  && Map[e.X + 1, e.Y] != null && Map[e.X + 1, e.Y].Frac == enemyFraction && (att == null || att.HitPoints > Map[e.X + 1, e.Y].HitPoints)) att = Map[e.X + 1, e.Y];
			if (e.X < Height - 1 && Map[e.X, e.Y + 1] != null && Map[e.X, e.Y + 1].Frac == enemyFraction && (att == null || att.HitPoints > Map[e.X, e.Y + 1].HitPoints)) att = Map[e.X, e.Y + 1];
			Attack(e, att);
			return true;
		}
		return true;
	}
}

int? GetDistance((int x, int y) p1, (int x, int y) p2)
{
	int[,] dmap = new int[Width, Height];
	var workload = new Stack<(int, int)>(); // <x,y>
	workload.Push((p1.x, p1.y));

	for (int yy = 0; yy < Height; yy++) for (int xx = 0; xx < Width; xx++) dmap[xx, yy] = (Map[xx, yy] != null) ? -1 : int.MaxValue;
	dmap[p1.x, p1.y] = 0;
	dmap[p2.x, p2.y] = int.MaxValue;

	while (workload.Any())
	{
		(var x, var y) = workload.Pop();

		if (y > 0          && dmap[x,     y - 1] - 1 > dmap[x, y]) { dmap[x, y - 1] = dmap[x, y] + 1; workload.Push((x,     y - 1)); } // [N]
		if (x < Width - 1  && dmap[x + 1, y    ] - 1 > dmap[x, y]) { dmap[x + 1, y] = dmap[x, y] + 1; workload.Push((x + 1, y    )); } // [E]
		if (x > 0          && dmap[x - 1, y    ] - 1 > dmap[x, y]) { dmap[x - 1, y] = dmap[x, y] + 1; workload.Push((x - 1, y    )); } // [W]
		if (y < Height - 1 && dmap[x,     y + 1] - 1 > dmap[x, y]) { dmap[x, y + 1] = dmap[x, y] + 1; workload.Push((x,     y + 1)); } // [S]
	}

	if (DUMP_REACHABLE) DumpReachable(dmap, p1, p2);

	return dmap[p2.x, p2.y]==int.MaxValue ? (int?)null : dmap[p2.x, p2.y];
}

void Move(Entity e, int x, int y)
{
	Map[e.X, e.Y] = null;
	e.X = x;
	e.Y = y;
	Map[e.X, e.Y] = e;
}

IEnumerable<(int x,int y, Entity e)> ListTargets(Fraction destFrac)
{
	foreach (var u in Units.Where(q => q.Frac==destFrac))
	{
		if (u.Y > 0          && Map[u.X,     u.Y - 1] == null) yield return (u.X,     u.Y - 1, u); // [N]
		if (u.X < Width - 1  && Map[u.X + 1, u.Y    ] == null) yield return (u.X + 1, u.Y,     u); // [E]
		if (u.X > 0          && Map[u.X - 1, u.Y    ] == null) yield return (u.X - 1, u.Y,     u); // [W]
		if (u.Y < Height - 1 && Map[u.X,     u.Y + 1] == null) yield return (u.X,     u.Y + 1, u); // [S]
	}
	
}

int[,] DoPathFinding(int dx, int dy)
{
	int[,] dmap = new int[Width, Height];
	var workload = new Stack<(int, int)>(); // <x,y>
	workload.Push((dx, dy));

	for (int yy = 0; yy < Height; yy++) for (int xx = 0; xx < Width; xx++) dmap[xx,yy] = (Map[xx,yy]!=null) ? -1 : int.MaxValue;
	dmap[dx,dy]=0;
	
	while (workload.Any())
	{
		(var x, var y) = workload.Pop();

		if (y > 0          && dmap[x, y - 1] - 1 > dmap[x, y]) { dmap[x, y - 1] = dmap[x, y] + 1; workload.Push((x, y - 1)); } // [N]
		if (x < Width - 1  && dmap[x + 1, y] - 1 > dmap[x, y]) { dmap[x + 1, y] = dmap[x, y] + 1; workload.Push((x + 1, y)); } // [E]
		if (x > 0          && dmap[x - 1, y] - 1 > dmap[x, y]) { dmap[x - 1, y] = dmap[x, y] + 1; workload.Push((x - 1, y)); } // [W]
		if (y < Height - 1 && dmap[x, y + 1] - 1 > dmap[x, y]) { dmap[x, y + 1] = dmap[x, y] + 1; workload.Push((x, y + 1)); } // [S]
	}
	
	return dmap;
}

void Attack(Entity src, Entity dst)
{
	dst.HitPoints -= src.AttackPower;
	if (dst.HitPoints <= 0) { dst.Alive = false; Units.Remove(dst); Map[dst.X, dst.Y] = null; }
}

void DumpPathFinding(int[,] dmap, Entity src, (int X, int Y) dst)
{
	StringBuilder b = new StringBuilder();
	for (int yy = 0; yy < Height; yy++)
	{
		b.Append("        ");
		for (int xx = 0; xx < Width; xx++)
		{
			if (xx == src.X && yy == src.Y) b.Append('+');
			else if (xx == dst.X && yy == dst.Y) b.Append('O');
			else if (dmap[xx, yy] == int.MaxValue) b.Append(' ');
			else if (dmap[xx, yy] < 0) b.Append('#');
			else if (dmap[xx, yy] <= 9) b.Append(dmap[xx, yy]);
			else if (dmap[xx, yy] < 36) b.Append((char)('A' + (dmap[xx, yy] - 10)));
			else b.Append('$');
		}
		b.AppendLine();
	}
	b.ToString().Dump();
}

void DumpReachable(int[,] rmap, (int X, int Y) src, (int X, int Y) dst)
{
	StringBuilder b = new StringBuilder();
	for (int yy = 0; yy < Height; yy++)
	{
		b.Append(": ");
		for (int xx = 0; xx < Width; xx++)
		{
			if (xx == src.X && yy == src.Y) b.Append('+');
			else if (xx == dst.X && yy == dst.Y) b.Append('O');
			else if (Map[xx,yy]?.Frac==Fraction.Wall) b.Append('#');
			else if (rmap[xx, yy] < int.MaxValue) b.Append(' ');
			else if (rmap[xx, yy] == int.MaxValue) b.Append('.');
			else b.Append('$');
		}
		b.AppendLine();
	}
	b.ToString().Dump();
}

void DumpMap(int gen)
{
	StringBuilder b = new StringBuilder();
	for (int yy = 0; yy < Height; yy++)
	{
		List<string> extra = new List<string>();
		
		for (int xx = 0; xx < Width; xx++)
		{
			if (Map[xx, yy] == null) { b.Append('.'); }
			else if (Map[xx, yy].Frac == Fraction.Wall)   { b.Append('#'); }
			else if (Map[xx, yy].Frac == Fraction.Elf)    { b.Append('E'); extra.Add($"E({Map[xx, yy].HitPoints})"); }
			else if (Map[xx, yy].Frac == Fraction.Goblin) { b.Append('G'); extra.Add($"G({Map[xx, yy].HitPoints})"); }
			else throw new Exception($"[{xx}|{yy}] := {Map[xx,yy]}");
		}
		b.Append($"   {string.Join(", ", extra)}{(extra.Any()?", ":"")}");
		b.AppendLine();
	}
	$"After {gen} rounds:".Dump();
	b.ToString().Trim().Dump();
	$"{new string(' ', Width)}   HP[G] := {Units.Where(p => p.Frac == Fraction.Goblin).Sum(p => p.HitPoints)}".Dump();
	$"{new string(' ', Width)}   HP[E] := {Units.Where(p => p.Frac == Fraction.Elf).Sum(p => p.HitPoints)}".Dump();
	"".Dump();
	"".Dump();
	"".Dump();
}

void Load(string[] input)
{
	Width  = input[0].Length;
	Height = input.Length;
	Map = new UserQuery.Entity[Width, Height];
	Units = new List<Entity>();
	
	for (int yy = 0; yy < Height; yy++)
	{
		for (int xx = 0; xx < Width; xx++)
		{
			if (input[yy][xx] == '#')
				Map[xx, yy] = new Entity { Frac = Fraction.Wall, AttackPower = 0, HitPoints = int.MaxValue, X=xx, Y=yy, Alive=true };
			else if (input[yy][xx] == '.')
				Map[xx, yy] = null;
			else if (input[yy][xx] == 'E')
				Units.Add(Map[xx, yy] = new Entity { Frac = Fraction.Elf,    AttackPower = 3, HitPoints = 200, X=xx, Y=yy, Alive=true });
			else if (input[yy][xx] == 'G')
				Units.Add(Map[xx, yy] = new Entity { Frac = Fraction.Goblin, AttackPower = 3, HitPoints = 200, X=xx, Y=yy, Alive=true });
			else
				throw new Exception($"[{xx}|{yy}] := {input[xx][yy]}");
		}
	}
}

