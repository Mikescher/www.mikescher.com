use crate::common::AdventOfCodeDay;


use std::collections::HashSet;

pub struct Day09 {
    input: Vec<u64>,
}

impl Day09 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/09_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                       .lines()
                        .map(|p| p.parse::<u64>().unwrap())
                        .collect::<Vec<u64>>();

        Self {
            input: data
        }
    }

    fn all_combinations(data: Vec<&u64>) -> HashSet<u64> {
        let mut hs: HashSet<u64> = HashSet::new();

        for i1 in 0..24 {
            for i2 in (i1+1)..25 {
                hs.insert(data[i1] + data[i2]);
            }
        }

        return hs;
    }

    fn find_invalid(&self) -> u64 {
        for i in 25..self.input.len() {
            let comb = Day09::all_combinations(self.input.iter().skip(i-25).take(25).collect());

            if !comb.contains(&self.input[i]) {
                return self.input[i];
            }
        }

        panic!();
    }
}

impl AdventOfCodeDay for Day09 {

    fn task_1(&self) -> String {
        return self.find_invalid().to_string();
    }

    fn task_2(&self) -> String  {
        let target = self.find_invalid();

        let mut sum  = self.input[0];
        let mut idx1 = 0; //inclusive
        let mut idx2 = 0; //inclusive

        loop {
            if sum == target {
                
                verboseln!("[{}..{}] [[{:?}]] = {} ({})", 
                            idx1, 
                            idx2, 
                            self.input.iter().skip(idx1).take(idx2-idx1+1).collect::<Vec<&u64>>(), 
                            self.input.iter().skip(idx1).take(idx2-idx1+1).sum::<u64>(),
                            target);


                return (self.input.iter().skip(idx1).take(idx2-idx1+1).min().unwrap() + self.input.iter().skip(idx1).take(idx2-idx1+1).max().unwrap()).to_string();

            } else if sum < target {

                idx2 += 1;
                sum  += self.input[idx2];

            } else if sum > target {

                sum  -= self.input[idx1];
                idx1 += 1;

            }

            verboseln!("[{}..{}] = {}", idx1, idx2, sum);
        }
    }
}