use crate::common::AdventOfCodeDay;

use regex::Regex;
use std::convert::TryInto;
use std::collections::HashSet;
use std::collections::hash_map::DefaultHasher;
use std::hash::{Hash, Hasher};

#[derive(Debug)]
pub struct Day22 {
    cards_p1: Vec<u32>,
    cards_p2: Vec<u32>,
}

impl Day22 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/22_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);

        let rex_lines = Regex::new(r"(\r?\n){2}").unwrap();
        let split = rex_lines.split(&input_str).collect::<Vec<&str>>();

        Self {
            cards_p1: split[0].lines().skip(1).map(|p| p.parse::<u32>().unwrap()).collect(),
            cards_p2: split[1].lines().skip(1).map(|p| p.parse::<u32>().unwrap()).collect(),
        }
    }
}

#[derive(Hash)]
struct Game {
    cards_p1: Vec<u32>,
    cards_p2: Vec<u32>,
}

impl Game {
    fn play_one(&mut self) {
        let c1 = self.cards_p1.remove(0);
        let c2 = self.cards_p2.remove(0);

        if c1 > c2 {
            self.cards_p1.push(c1);
            self.cards_p1.push(c2);
        } else {
            self.cards_p2.push(c2);
            self.cards_p2.push(c1);
        }
    }
    
    fn play(&mut self) -> usize {
        verboseln!("Round[0]:");
        verboseln!("    P1: {:?}", self.cards_p1);
        verboseln!("    P2: {:?}", self.cards_p2);
        verboseln!();

        let mut winner = 0;
        for i in 1.. {

            self.play_one();

            verboseln!("Round[{}]:", i);
            verboseln!("    P1: {:?}", self.cards_p1);
            verboseln!("    P2: {:?}", self.cards_p2);
            verboseln!();

            if self.cards_p1.is_empty() { winner = 2; break; }
            if self.cards_p2.is_empty() { winner = 1; break; }
        }

        return winner;
    }

    fn score(&self, player: usize) -> u128 {

        let cards = match player {
            1 => &self.cards_p1,
            2 => &self.cards_p2,
            _ => panic!(),
        };

        return cards.iter()
                    .rev()
                    .enumerate()
                    .map(|(i,v)| ((i+1) as u128, *v as u128))
                    .map(|(i,v)| i*v)
                    .fold(0, |a,b| a + b);
    }
    
    fn play_recursive(&mut self, game_id: u32) -> usize {

        verboseln!("=== Game {} ===", game_id);
        verboseln!();

        let mut history = HashSet::<u64>::new();

        let mut winner = 0;
        for i in 1.. {

            let mut dhasher = DefaultHasher::new();
            self.hash(&mut dhasher);
            let hash = dhasher.finish();
            
            if history.contains(&hash) {
                verboseln!("Player 1 wins inf-recursion-protection in game: {}", game_id);
                return 1;
            } else {
                history.insert(hash);
            }

            verboseln!("-- Round {} (Game {}) --", i, game_id);
            verboseln!("Player 1's deck: {:?}", self.cards_p1);
            verboseln!("Player 2's deck: {:?}", self.cards_p2);

            let c1 = self.cards_p1.remove(0);
            let c2 = self.cards_p2.remove(0);
            
            verboseln!("Player 1 plays: {}", c1);
            verboseln!("Player 2 plays: {}", c2);

            if self.cards_p1.len() as u32 >= c1 && self.cards_p2.len() as u32 >= c2 {
                
                verboseln!("Playing a sub-game to determine the winner...");
                verboseln!();
                let mut subgame = Game { 
                    cards_p1: self.cards_p1.iter().take(c1.try_into().unwrap()).map(|p|*p).collect::<Vec<_>>(), 
                    cards_p2:self.cards_p2.iter().take(c2.try_into().unwrap()).map(|p|*p).collect::<Vec<_>>() 
                };
                let sg_winner = subgame.play_recursive(game_id+1);
                verboseln!();
                verboseln!("...anyway, back to game {}.", game_id);

                if sg_winner == 1 {
                    verboseln!("Player 1 wins round {} of game {}!", i, game_id);
                    self.cards_p1.push(c1);
                    self.cards_p1.push(c2);
                } else {
                    verboseln!("Player 2 wins round {} of game {}!", i, game_id);
                    self.cards_p2.push(c2);
                    self.cards_p2.push(c1);
                }

            } else {
                if c1 > c2 {
                    verboseln!("Player 1 wins round {} of game {}!", i, game_id);
                    self.cards_p1.push(c1);
                    self.cards_p1.push(c2);
                } else {
                    verboseln!("Player 2 wins round {} of game {}!", i, game_id);
                    self.cards_p2.push(c2);
                    self.cards_p2.push(c1);
                }
            }

            if self.cards_p1.is_empty() { winner = 2; break; }
            if self.cards_p2.is_empty() { winner = 1; break; }

            verboseln!();
        }

        verboseln!("The winner of game {} is player {}!", game_id, winner);

        if game_id == 1 {
            
            verboseln!();
            verboseln!("== Post-game results ==");
            verboseln!("Player 1's deck: {:?}", self.cards_p1);
            verboseln!("Player 2's deck: {:?}", self.cards_p2);
        }

        return winner;
    }
}

impl AdventOfCodeDay for Day22 {

    fn task_1(&self) -> String {
        let mut game = Game { cards_p1: self.cards_p1.clone(), cards_p2: self.cards_p2.clone() };
        let winner = game.play();
        return game.score(winner).to_string();
    }

    fn task_2(&self) -> String  {
        let mut game = Game { cards_p1: self.cards_p1.clone(), cards_p2: self.cards_p2.clone() };
        let winner = game.play_recursive(1);
        return game.score(winner).to_string();
    }
}