import { CalenderDemoPage } from './app.po';

describe('calender-demo App', function() {
  let page: CalenderDemoPage;

  beforeEach(() => {
    page = new CalenderDemoPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
