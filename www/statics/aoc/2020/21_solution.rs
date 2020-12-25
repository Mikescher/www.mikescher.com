use crate::common::AdventOfCodeDay;

use std::collections::HashMap;

#[derive(Debug)]
struct Food {
    ingredients: Vec<String>,
    allergens: Vec<String>,
}

impl Food {
    fn parse(line: String) -> Food {
        let split = line.split(" (contains ").collect::<Vec<_>>();

        return Food {
            ingredients: split[0].split(" ").map(String::from).collect(),
            allergens: split[1].replace(")", "").split(", ").map(String::from).collect(),
        }
    }
}

#[derive(Debug)]
pub struct Day21 {
    input: Vec<Food>,
}

impl Day21 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/21_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(|p| Food::parse(String::from(p)))
                        .collect::<Vec<_>>();

        Self {
            input: data
        }
    }
}

impl Day21 {
    fn find_allergen_candidates(&self) -> Vec<(String, Vec<String>)> {
        let mut ag_map = HashMap::<String, Vec<String>>::new();

        for food in &self.input {
            for allergen in &food.allergens {

                if let Some(candidates) = ag_map.get_mut(allergen) {

                    candidates.retain(|c| food.ingredients.contains(c))

                } else {
                    ag_map.insert(allergen.clone(), food.ingredients.clone());
                }
            }
        }

        loop {
            let mut changed = false;

            for rm in ag_map.iter().filter(|(_,v)| v.len()==1).map(|(_,v)| v[0].clone()).collect::<Vec<_>>() {

                for (_, cand_mut) in ag_map.iter_mut() {
                    if cand_mut.len() == 1 { continue; }

                    let l1 = cand_mut.len();
                    cand_mut.retain(|v| *v != rm);
                    if cand_mut.len() != l1 { changed = true; }
                }

            }

            if !changed { break; }
        }

        return ag_map.iter().map(|(k,v)| (k.clone(), v.clone())).collect::<Vec<_>>();
    }
}

impl AdventOfCodeDay for Day21 {

    fn task_1(&self) -> String {

        //for v in &self.input { verboseln!("{:?}", v); }

        let candidates = self.find_allergen_candidates();

        if is_verbose!() {
            for (k,v) in &candidates { verboseln!("{: <9} ({}) := {:?}", k, v.len(), v); }
        }

        let allergen_ingred = candidates.iter().flat_map(|p| p.1.iter() ).collect::<Vec<_>>();

        return self.input.iter().flat_map(|p| p.ingredients.iter()).filter(|ig| !allergen_ingred.contains(&ig)).count().to_string();
    }

    fn task_2(&self) -> String  {

        let mut candidates = self.find_allergen_candidates();
        candidates.sort_by(|a,b| a.0.cmp(&b.0));

        if is_verbose!() {
            for (k,v) in &candidates { verboseln!("{: <9} ({}) := {:?}", k, v.len(), v); }
        }

        return candidates.iter().map(|(_,v)|v[0].clone()).collect::<Vec<String>>().join(",");
    }
}