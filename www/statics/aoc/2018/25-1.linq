<Query Kind="Program" />

void Main()
{
	var points = File
		.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"25_input.txt"))
		.Select(p => p.Split(',').Select(q => int.Parse(q.Trim())).ToArray())
		.ToList();
		
	var constellations = new List<List<int[]>>();
	
	while(points.Any())
	{
		var p = points.First();
		points.RemoveAt(0);
		constellations.Add(Constell(p, points).ToList());
	}

	//constellations.Select(c => c.Select(q => string.Join(" ; ", q))).Dump();
	constellations.Count().Dump();
}

IEnumerable<int[]> Constell(int[] p, List<int[]> points)
{
	yield return p;
	for(;;)
	{
		var f=false;
		for (int i = 0; i < points.Count; i++)
		{
			if (Dist(p, points[i]) <= 3)
			{
				var np = points[i];
				points.RemoveAt(i);
				foreach (var p2 in Constell(np, points)) yield return p2;
				f=true;
				break;
			}
		}
		if (!f) yield break;
	}
}

int Dist(int[] a, int[] b) => Math.Abs(a[0] - b[0]) + Math.Abs(a[1] - b[1]) + Math.Abs(a[2] - b[2]) + Math.Abs(a[3] - b[3]);