<Query Kind="Statements" />


var guards = new List<(int id, int awake, int[] minutes)>();

var data = File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"04_input.txt"))
	.Where(p=>!string.IsNullOrWhiteSpace(p))
	.OrderBy(p=>p);

int guard=-1;
int wakeup=0;
int wakesum=0;
bool awake=true;
int[] mins = new int[60];
foreach (var line in data)
{
	int m = int.Parse(line.Substring(15,2));
	if (line.Contains("Guard"))
	{
		if (awake)
		{
			wakesum += (60 - wakeup);
			for (int i = wakeup; i < 60; mins[i++] = 1) ;
		}
		
		if (guard>=0)guards.Add((guard, wakesum, mins));

		guard = int.Parse(line.Substring(26).Split(' ')[0]);
		awake=true;
		wakeup=0;
		wakesum=0;
		mins = new int[60];
	}
	else if (line.Contains("falls asleep"))
	{
		awake = false;
		wakesum += (m-wakeup);
		for (int i = wakeup; i < m; mins[i++]=1);
	}
	else if (line.Contains("wakes up"))
	{
		awake = true;
		wakeup=m;
	}
	else throw new Exception();
}


guards
	.GroupBy(g => g.id)
	.Select(p => new
	{
		id = p.Key,
		awake_total = p.Sum(q => q.awake),
		asleep_total = p.Sum(q => 60 - q.awake),
		mins = p.Select(q => q.minutes).Aggregate((a, b) => a.Zip(b, (u, v) => u + v).ToArray()),
		shifts = p.Count(),
	})
	.Select(p => new
	{
		id = p.id,
		awake_total = p.awake_total,
		asleep_total = p.asleep_total,
		shifts = p.shifts,
		mins = p.mins,
		most_wake_min = p.mins.Select((v, i) => (v, i)).OrderByDescending(q => q.v),
		most_sleep_min = p.mins.Select((v, i) => new { v = p.shifts - v, i = i}).OrderByDescending(q => q.v)
	})
	.Select(p => new
	{
		id = p.id,
		awake_total = p.awake_total,
		asleep_total = p.asleep_total,
		shifts = p.shifts,
		mins = p.mins,
		most_sleep_min = p.most_sleep_min,
		most_wake_min = p.most_wake_min,
		result = p.most_wake_min.First().i * p.id,
		result2 = p.most_sleep_min.First().i * p.id,
	})
	.OrderByDescending(p => p.most_sleep_min.First().v)
	//.First()
	//.result
	.Dump();
