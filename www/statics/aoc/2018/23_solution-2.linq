<Query Kind="Statements" />

class C3 { public long X, Y, Z; }

void Main()
{
	var input = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"23_input.txt"))
		.Where(p => !string.IsNullOrWhiteSpace(p))
		.Select(p => new
		{
			X = long.Parse(p.Split(' ')[0].Substring(5).Split(',')[0].Trim(new[] { ' ', '<', '>', ',' })),
			Y = long.Parse(p.Split(' ')[0].Substring(5).Split(',')[1].Trim(new[] { ' ', '<', '>', ',' })),
			Z = long.Parse(p.Split(' ')[0].Substring(5).Split(',')[2].Trim(new[] { ' ', '<', '>', ',' })),
			R = long.Parse(p.Split(' ')[1].Substring(2).Trim(new[] { ' ', '<', '>', ',' })),
		})
		.ToList();

	var x_min = input.Min(i => i.X);
	var x_max = input.Max(i => i.X);
	var y_min = input.Min(i => i.Y);
	var y_max = input.Max(i => i.Y);
	var z_min = input.Min(i => i.Z);
	var z_max = input.Max(i => i.Z);

	long dist = 1;
	for (; dist < x_max - x_min; dist *= 2) ;

	long target_count = 0;
	C3 best = null;
	long? best_val = null;

	for (; dist > 0;)
	{
		target_count = 0;
		best = null;
		best_val = null;

		for (long x = x_min; x <= x_max; x += dist)
		{
			for (long y = y_min; y <= y_max; y += dist)
			{
				for (long z = z_min; z <= z_max; z += dist)
				{
					var count = 0;
					foreach (var b in input)
					{
						var calc = Math.Abs(x - b.X) + Math.Abs(y - b.Y) + Math.Abs(z - b.Z);
						if ((calc - b.R) / dist <= 0) count++;
					}
					if (count > target_count)
					{
						target_count = count;
						best_val = Math.Abs(x) + Math.Abs(y) + Math.Abs(z);
						best = new C3 { X = x, Y = y, Z = z };
					}
					else if (count == target_count)
					{
						if (Math.Abs(x) + Math.Abs(y) + Math.Abs(z) < best_val)
						{
							best_val = Math.Abs(x) + Math.Abs(y) + Math.Abs(z);
							best = new C3 { X = x, Y = y, Z = z };
						}
					}
				}
			}
		}

		x_min = best.X - dist;
		x_max = best.X + dist;
		y_min = best.Y - dist;
		y_max = best.Y + dist;
		z_min = best.Z - dist;
		z_max = best.Z + dist;
		dist /= 2;
	}
	best_val.Dump();
}
