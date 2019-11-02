<Query Kind="Program" />

class ArmyGroup
{
	public string Source;
	
	public int UnitCount;
	public int HitPoints;
	public List<string> Weakness = new List<string>();
	public List<string> Immunity = new List<string>();
	public string DamageType;
	public int DamageValue;
	public int Initiative;

	public int EffectivePower => UnitCount * DamageValue;
	public bool Alive => UnitCount>0;
	
	public ArmyGroup NextTarget = null;
	public bool IsTargeted = false;
}

void Main() => Enumerable.Range(0, int.MaxValue).Select(Calc).First(b=>b>0).Dump();

int Calc(int boost)
{
	var groups = Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"24_input.txt")));

	foreach(var g in groups.Where(p => p.Source=="ImmuneSystem")) g.DamageValue += boost;

	for (int gen = 0; ; gen++)
	{
		if (!(groups.GroupBy(g => g.Source).All(g => g.Any(a => a.Alive)))) break;

		bool dmg = Fight(groups);
		
		if (!dmg) return 0;
	}

	return groups.Where(p => p.Source=="ImmuneSystem").Sum(p => p.UnitCount) - groups.Where(p => p.Source=="Infection").Sum(p => p.UnitCount);
}

List<ArmyGroup> Load(string[] lines)
{
	return new[]
	{
		lines.Skip(1).TakeWhile(l => !string.IsNullOrWhiteSpace(l)).Select(l => LoadSingle("ImmuneSystem", l)),
		lines.Skip(1).SkipWhile(l => !string.IsNullOrWhiteSpace(l)).Skip(2).Select(l => LoadSingle("Infection", l))
	}
	.SelectMany(p=>p)
	.ToList();
}

ArmyGroup LoadSingle(string src, string line)
{
	var ag = new ArmyGroup { Source=src };

	var i1 = line.IndexOf(' ');
	ag.UnitCount = int.Parse(line.Substring(0, i1).Trim());
	line = line.Substring(i1).Trim().Substring(15).Trim();

	var i6 = line.IndexOf(' ');
	ag.HitPoints = int.Parse(line.Substring(0, i6).Trim());
	line = line.Substring(i6).Trim().Substring(11).Trim();
	
	var i2 = line.IndexOf(')');
	if (i2 != -1)
	{
		var spec0 = line.Substring(1, i2).TrimEnd(')');
		line = line.Substring(1).Substring(i2).Substring(1).Trim();

		foreach (var spc in spec0.Split(';').Select(p => p.Trim()))
		{
			if (spc.StartsWith("weak to")) ag.Weakness.AddRange(spc.Substring("weak to".Length).Trim().Split(',').Select(p => p.Trim()));
			if (spc.StartsWith("immune to")) ag.Immunity.AddRange(spc.Substring("immune to".Length).Trim().Split(',').Select(p => p.Trim()));
		}
	}
	line = line.Substring(25).Trim();

	var i3 = line.IndexOf(' ');
	ag.DamageValue = int.Parse(line.Substring(0, i3).Trim());
	line = line.Substring(i3).Trim().Trim();

	var i4 = line.IndexOf(' ');
	ag.DamageType = line.Substring(0, i4).Trim();
	line = line.Substring(i4).Trim().Trim();

	var i5 = line.LastIndexOf(' ');
	ag.Initiative = int.Parse(line.Substring(i5).Trim());

	return ag;
}

bool Fight(List<ArmyGroup> groups)
{
	// PHASE 1

	foreach (var g in groups) { g.IsTargeted=false; g.NextTarget=null; }
	
	foreach (var g in groups.Where(g => g.Alive).OrderByDescending(g => g.EffectivePower).ThenByDescending(g => g.Initiative))
	{
		SelectTarget(g, groups);
	}

	// PHASE 2

	bool d = false;

	foreach (var g in groups.Where(g => g.Alive).OrderByDescending(g => g.Initiative).Where(g => g.NextTarget!=null))
	{
		var a = Attack(g, g.NextTarget);
		if (a)d=true;
	}
	return d;
}

void SelectTarget(ArmyGroup att, List<ArmyGroup> groups)
{
	att.NextTarget = groups
		.Where(g => g.Alive)
		.Where(g => g.Source != att.Source)
		.Where(g => !g.IsTargeted)
		.Where(g => CalcFullDamage(att, g)>0)
		.OrderByDescending(g => CalcFullDamage(att, g))
		.ThenByDescending(g => g.EffectivePower)
		.ThenByDescending(g => g.Initiative)
		.FirstOrDefault();
	if (att.NextTarget != null) att.NextTarget.IsTargeted = true;
}

int CalcFullDamage(ArmyGroup att, ArmyGroup def)
{
	if (att.UnitCount==0) return 0;

	var dmg = att.EffectivePower;
	if (def.Immunity.Contains(att.DamageType)) return 0;
	if (def.Weakness.Contains(att.DamageType)) return dmg*2;
	return dmg;
}

bool Attack(ArmyGroup att, ArmyGroup def)
{
	var dmg = CalcFullDamage(att, def);
	var kill = (int)(dmg / def.HitPoints);
	def.UnitCount -= kill;
	if (def.UnitCount<0) def.UnitCount = 0;
	return kill>0;
	
}