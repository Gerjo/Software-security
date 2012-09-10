#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <time.h>

using namespace std;

int number;

void hint(int guess)
{
	if(guess > number) printf("The number is lower than that.\n");
	else if(guess < number) printf("The number is higher than that.\n");
}

void unsafe()
{
	srand(time(NULL));
	number = rand() % 10;
	char guessedRight = '0';
	char buffer[2];

	while(guessedRight == '0') {
		gets(buffer);

		hint(atoi(buffer));
		if(atoi(buffer) == number)
			guessedRight = '1';

		printf("Status: %c \n", guessedRight);
	}
}

void safe()
{
	srand(time(NULL));
	number = rand() % 10;
	char guessedRight = '0';
	char buffer[2];

	while(guessedRight == '0') {
		// NOTE: gets_s is only since recent in the C standard. (ISO/IEC 9899:2011)
		gets_s(buffer, 2);
		//fgets(buffer, sizeof(buffer), stdin);
		//
		//char c = getchar();
		//while(c != '\n' && c != EOF)
		//	c = getchar();
		
		hint(atoi(buffer));
		
		if(atoi(buffer) == number)
			guessedRight = '1';

		printf("Status: %c\n", guessedRight);
	}
}

int main(int argc, char *argv[])
{
	printf("Guess the number\n");
	unsafe();
	printf("Congrats, you've found it.\n");
	system("pause");
}
