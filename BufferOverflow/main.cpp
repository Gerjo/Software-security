#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <time.h>

using namespace std;

int main(int argc, char *argv[])
{
	srand(time(NULL));
	int number = rand() % 10;
	char guessedRight = '0';
	char buffer[2];

	cout << "Guess the number." << endl;
	while(guessedRight == '0') {
		cin >> buffer;
		if(buffer[0] == number)
			guessedRight = '1';

		printf("Status: %c \n", guessedRight);
	}
	printf("Broke out of the while loop with status %s.\n", guessedRight);

	cin.get();

}