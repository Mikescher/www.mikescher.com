use crate::common::AdventOfCodeDay;

use itertools::Itertools;
use std::collections::HashMap;

pub struct Day10 {
    input: Vec<u32>,
}

impl Day10 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/10_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(|p| p.parse::<u32>().unwrap())
                        .collect::<Vec<u32>>();

        Self {
            input: data
        }
    }

    fn path_count(cache: &mut HashMap<usize, u128>, list: &Vec<u32>, idx: usize) -> u128 {
        if idx == 0 {
            return 1;
        }
        if let Some(cv) = cache.get(&idx) {
            verboseln!("(#)  {}", idx);
            return *cv;
        }

        verboseln!("[::] {}", idx);

        let mut r = 0;

        let me = list[idx];

        for delta in 1..4 {
            let other_idx = idx as i32 - delta;

            if other_idx < 0 {
                continue;
            }

            let other = list[other_idx as usize];
            if me - other <= 3 {
                r += Day10::path_count(cache, list, other_idx as usize);
            }
        }

        cache.insert(idx, r);

        return r;
    }
}

impl AdventOfCodeDay for Day10 {

    fn task_1(&self) -> String {

        let (min, max) = self.input.iter().minmax().into_option().unwrap();

        verboseln!("min := {}", min);
        verboseln!("max := {}", max);

        let diff = self.input
                       .iter()
                       .chain([0, *max + 3].iter())
                       .sorted()
                       .collect::<Vec<&u32>>()
                       .windows(2)
                       .map(|p| p[1] - p[0])
                       .collect::<Vec<u32>>();

        let c1 = diff.iter().filter(|v| **v == 1).count();
        let c3 = diff.iter().filter(|v| **v == 3).count();

        verboseln!("{} * {} = {}", c1, c3, c1*c3);

        return (c1 * c3).to_string() //TODO
    }

    fn task_2(&self) -> String  {

        let max = self.input.iter().max().unwrap();

        let all = self.input
                       .iter()
                       .chain([0, *max + 3].iter())
                       .sorted()
                       .map(|p| *p)
                       .collect::<Vec<u32>>();

        let mut hmap: HashMap<usize, u128> = HashMap::new();
        //for i in 0..(all.len()) {
        //    Day10::path_count(&mut hmap, &all, i);
        //}
        let total = Day10::path_count(&mut hmap, &all, all.len()-1);

        return total.to_string();
    }
}