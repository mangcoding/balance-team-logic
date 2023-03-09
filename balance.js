// Get All Combination without duplicate
function getCombinations(array, n) {
  const count = array.length;
  const combinations = [];

  if (n > count) {
    return combinations;
  }

  for (let i = 0; i < count; i++) {
    const temp = [array[i]];

    if (n === 1) {
      combinations.push(temp);
    } else {
      const remaining = array.slice(i + 1);
      const subcombinations = getCombinations(remaining, n - 1);

      for (const subarray of subcombinations) {
        combinations.push(temp.concat(subarray));
      }
    }
  }

  return combinations;
}

function compareByEloSum(a, b) {
  const balanceElo = this.balanceElo;
  const aSum = Math.abs(a.map(player => player.elo).reduce((total, elo) => total + elo) - balanceElo);
  const bSum = Math.abs(b.map(player => player.elo).reduce((total, elo) => total + elo) - balanceElo);
  return aSum > bSum ? 1 : -1;
}

function filterByEloSum(array, targetSum) {
  return array.filter(element => element.map(player => player.elo).reduce((total, elo) => total + elo) === targetSum);
}

function udiffCompare(a, b) {
  return a.name.localeCompare(b.name);
}

//example usage

// Define the list of players
const players = [
  { name: 'Yans', elo: 90 },
  { name: 'Zhombie', elo: 65 },
  { name: 'Apple', elo: 85 },
  { name: 'Lelembut', elo: 55 },
  { name: 'VGB', elo: 85 },
  { name: 'Godeg', elo: 70 },
  { name: 'Kaipang', elo: 75 },
  { name: 'Putih', elo: 65 },
];

const combinationPlayers = getCombinations(players, 4);
// Get the balance number
const totalElo = players.map(player => player.elo).reduce((total, elo) => total + elo);
const balanceElo = Math.ceil(totalElo / 2);
combinationPlayers.sort(compareByEloSum.bind({ balanceElo }));
const targetElo = combinationPlayers[0].map(player => player.elo).reduce((total, elo) => total + elo);
const selectedTeam = filterByEloSum(combinationPlayers, targetElo);

const half = Math.ceil(selectedTeam.length / 2);
let i = 0;
for (const teamMember of selectedTeam.slice(0, half)) {
  console.log(`Team ${i+1}:`);
  for (const player of teamMember) {
    console.log(`${player.name} (Elo: ${player.elo})`);
  }
  console.log(`Total: ${teamMember.map(player => player.elo).reduce((total, elo) => total + elo)}`);
  console.log('VS');
  const otherPlayer = players.filter(player => !teamMember.includes(player)).sort(udiffCompare);
  for (const player of otherPlayer) {
    console.log(`${player.name} (Elo: ${player.elo})`);
  }
  console.log(`Total: ${otherPlayer.map(player => player.elo).reduce((total, elo) => total + elo)}\n`);
  i++;
}