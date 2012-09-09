#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <time.h>

using namespace std;

void unsafe()
{
	srand(time(NULL));
	int number = rand() % 10;
	char guessedRight = '0';
	char buffer[2];

	while(guessedRight == '0') {
		gets(buffer);

		if(atoi(&buffer[0]) == number)
			guessedRight = '1';

		printf("Status: %c \n", guessedRight);
	}
}

void safe()
{
	srand(time(NULL));
	int number = rand() % 10;
	char guessedRight = '0';
	char *buffer = new char[2];

	while(guessedRight == '0') {

		// NOTE: gets_s is only since recent in the C standard. (ISO/IEC 9899:2011)
		if(gets_s(buffer, 2) == 0)
		{
			printf("This is safe, so stop fooling around.\n");
		}

		if(atoi(&buffer[0]) == number)
			guessedRight = '1';

		printf("Status: %c\n", guessedRight);
	}

	delete [] buffer;
}

int main(int argc, char *argv[])
{
	printf("Guess the number\n");
	safe();
	printf("Congrats, you've found it.\n");
	system("pause");
}