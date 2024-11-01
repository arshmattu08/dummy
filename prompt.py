from .user_interface import message

def counter(token):
    print('counter')
    count = 0
    with open('corpus.txt', 'r') as f:
        data = f.read()
        data = data.split()
    for el in data:
        if el == token:
            count+=1
    return count

def report_count(token):
    message(token)