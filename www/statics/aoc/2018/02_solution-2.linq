<Query Kind="Statements" />

var data = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"02_input.txt"));

data
	.Select(d1 => data.Where(d2 => d1.Zip(d2.ToCharArray(), (a,b) => a!=b).Count(p=>p)==1  ))
	.Where(p => p.Any())
	.Select(p => p.First())
	.Aggregate((a, b) => new string(a.Zip(b.ToCharArray(), (u,v)=>(u==v?u:'_')).ToArray())  )
	.Replace("_", "")
	.Dump();